<?php

namespace App\Console\Commands;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\Reflection\DocBlock;
use Barryvdh\Reflection\DocBlock\Context;
use Barryvdh\Reflection\DocBlock\Serializer as DocBlockSerializer;
use Barryvdh\Reflection\DocBlock\Tag;
use Carbon\Carbon;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\Enum\Laravel\Enum;

class IdeHelperModelsCommand extends ModelsCommand
{
    protected function customizePhpDoc(string $class, string $docComment): string
    {
        // remove leading FQCN comment
        $docComment = Str::replace("* {$class}", "* class {$class}", $docComment);

        // remove default Eloquent mixin
        $docComment = Str::replace('@mixin \Eloquent', '', $docComment);

        // replace illuminate carbon with default carbon
        $docComment = Str::replace(IlluminateCarbon::class, Carbon::class, $docComment);

        // remove wrongfully added query methods
        $docComment = preg_replace('/@method static .+ newQuery\(\)/', '', $docComment);
        $docComment = preg_replace('/@method static .+ newModelQuery\(\)/', '', $docComment);

        // remove blank lines
        $docComment = preg_replace("/\s\*\s*\n/", '', $docComment);

        return $docComment;
    }

    protected function checkForCastableCasts(string $type, array $params = []): string
    {
        if (is_subclass_of($type, Enum::class)) {
            return $type;
        }

        return parent::checkForCastableCasts($type, $params);
    }

    /**
     * @see `START customization` and `END customization` comment
     * @see \App\Console\Commands\IdeHelperModelsCommand::customizePhpDoc()
     * @see \Barryvdh\LaravelIdeHelper\Console\ModelsCommand::createPhpDocs()
     *
     * @param class-string<\Illuminate\Database\Eloquent\Model> $class
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function createPhpDocs($class): string
    {
        $reflection = new ReflectionClass($class);
        $namespace = $reflection->getNamespaceName();
        $classname = $reflection->getShortName();
        $originalDoc = $reflection->getDocComment();
        $keyword = $this->getClassKeyword($reflection);
        $interfaceNames = array_diff_key(
            $reflection->getInterfaceNames(),
            $reflection->getParentClass()->getInterfaceNames()
        );

        if ($this->reset) {
            $phpdoc = new DocBlock('', new Context($namespace));
            if ($this->keep_text) {
                $phpdoc->setText(
                    (new DocBlock($reflection, new Context($namespace)))->getText()
                );
            }
        } else {
            $phpdoc = new DocBlock($reflection, new Context($namespace));
        }

        if (! $phpdoc->getText()) {
            $phpdoc->setText($class);
        }

        $properties = [];
        $methods = [];
        foreach ($phpdoc->getTags() as $tag) {
            $name = $tag->getName();
            if ($name == 'property' || $name == 'property-read' || $name == 'property-write') {
                $properties[] = $tag->getVariableName();
            } elseif ($name == 'method') {
                $methods[] = $tag->getMethodName();
            }
        }

        foreach ($this->properties as $name => $property) {
            $name = "\${$name}";

            if ($this->hasCamelCaseModelProperties()) {
                $name = Str::camel($name);
            }

            if (in_array($name, $properties)) {
                continue;
            }
            if ($property['read'] && $property['write']) {
                $attr = 'property';
            } elseif ($property['write']) {
                $attr = 'property-write';
            } else {
                $attr = 'property-read';
            }

            $tagLine = trim("@{$attr} {$property['type']} {$name} {$property['comment']}");
            $tag = Tag::createInstance($tagLine, $phpdoc);
            $phpdoc->appendTag($tag);
        }

        ksort($this->methods);

        foreach ($this->methods as $name => $method) {
            if (in_array($name, $methods)) {
                continue;
            }
            $arguments = implode(', ', $method['arguments']);
            $tagLine = "@method static {$method['type']} {$name}({$arguments})";
            if ($method['comment'] !== '') {
                $tagLine .= " {$method['comment']}";
            }
            $tag = Tag::createInstance($tagLine, $phpdoc);
            $phpdoc->appendTag($tag);
        }

        if ($this->write && ! $phpdoc->getTagsByName('mixin')) {
            $eloquentClassNameInModel = $this->getClassNameInDestinationFile($reflection, 'Eloquent');
            $phpdoc->appendTag(Tag::createInstance('@mixin '.$eloquentClassNameInModel, $phpdoc));
        }
        if ($this->phpstorm_noinspections) {
            /**
             * Facades, Eloquent API.
             *
             * @see https://www.jetbrains.com/help/phpstorm/php-fully-qualified-name-usage.html
             */
            $phpdoc->appendTag(Tag::createInstance('@noinspection PhpFullyQualifiedNameUsageInspection', $phpdoc));
            /**
             * Relations, other models in the same namespace.
             *
             * @see https://www.jetbrains.com/help/phpstorm/php-unnecessary-fully-qualified-name.html
             */
            $phpdoc->appendTag(
                Tag::createInstance('@noinspection PhpUnnecessaryFullyQualifiedNameInspection', $phpdoc)
            );
        }

        $serializer = new DocBlockSerializer();
        $docComment = $serializer->getDocComment($phpdoc);

        if ($this->write_mixin) {
            $phpdocMixin = new DocBlock($reflection, new Context($namespace));
            // remove all mixin tags prefixed with IdeHelper
            foreach ($phpdocMixin->getTagsByName('mixin') as $tag) {
                if (Str::startsWith($tag->getContent(), 'IdeHelper')) {
                    $phpdocMixin->deleteTag($tag);
                }
            }

            $mixinClassName = "IdeHelper{$classname}";
            $phpdocMixin->appendTag(Tag::createInstance("@mixin {$mixinClassName}", $phpdocMixin));
            $mixinDocComment = $serializer->getDocComment($phpdocMixin);
            // remove blank lines if there's no text
            if (! $phpdocMixin->getText()) {
                $mixinDocComment = preg_replace("/\s\*\s*\n/", '', $mixinDocComment);
            }

            foreach ($phpdoc->getTagsByName('mixin') as $tag) {
                if (Str::startsWith($tag->getContent(), 'IdeHelper')) {
                    $phpdoc->deleteTag($tag);
                }
            }
            $docComment = $serializer->getDocComment($phpdoc);
        }

        // START customization
        $docComment = $this->customizePhpDoc($class, $docComment);
        // END customization

        if ($this->write) {
            $modelDocComment = $this->write_mixin ? $mixinDocComment : $docComment;
            $filename = $reflection->getFileName();
            $contents = $this->files->get($filename);
            if ($originalDoc) {
                $contents = str_replace($originalDoc, $modelDocComment, $contents);
            } else {
                $replace = "{$modelDocComment}\n";
                $pos = strpos($contents, "final class {$classname}") ?: strpos($contents, "class {$classname}");
                if ($pos !== false) {
                    $contents = substr_replace($contents, $replace, $pos, 0);
                }
            }
            if ($this->files->put($filename, $contents)) {
                $this->info('Written new phpDocBlock to '.$filename);
            }
        }

        $classname = $this->write_mixin ? $mixinClassName : $classname;
        $output = "namespace {$namespace}{\n{$docComment}\n\t{$keyword}class {$classname} ";

        if (! $this->write_mixin) {
            $output .= "extends \Eloquent ";

            if ($interfaceNames) {
                $interfaces = implode(', \\', $interfaceNames);
                $output .= "implements \\{$interfaces} ";
            }
        }

        return $output."{}\n}\n\n";
    }
}
