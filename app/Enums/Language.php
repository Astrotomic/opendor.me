<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @method static self ABAP()
 * @method static self ABAP_CDS()
 * @method static self ACTIONSCRIPT()
 * @method static self ADA()
 * @method static self ADBLOCK_FILTER_LIST()
 * @method static self ADOBE_FONT_METRICS()
 * @method static self AGDA()
 * @method static self AGS_SCRIPT()
 * @method static self AIDL()
 * @method static self AL()
 * @method static self ALLOY()
 * @method static self ALPINE_ABUILD()
 * @method static self ALTIUM_DESIGNER()
 * @method static self AMPL()
 * @method static self ANGELSCRIPT()
 * @method static self ANTLERS()
 * @method static self ANTLR()
 * @method static self ANT_BUILD_SYSTEM()
 * @method static self APACHECONF()
 * @method static self APEX()
 * @method static self API_BLUEPRINT()
 * @method static self APL()
 * @method static self APOLLO_GUIDANCE_COMPUTER()
 * @method static self APPLESCRIPT()
 * @method static self ARC()
 * @method static self ARDUINO()
 * @method static self ASCIIDOC()
 * @method static self ASL()
 * @method static self ASP()
 * @method static self ASPECTJ()
 * @method static self ASPNET()
 * @method static self ASSEMBLY()
 * @method static self ASTRO()
 * @method static self ASYMPTOTE()
 * @method static self ATS()
 * @method static self AUGEAS()
 * @method static self AUTOHOTKEY()
 * @method static self AUTOIT()
 * @method static self AVRO_IDL()
 * @method static self AWK()
 * @method static self BALLERINA()
 * @method static self BASIC()
 * @method static self BATCHFILE()
 * @method static self BEEF()
 * @method static self BEFUNGE()
 * @method static self BERRY()
 * @method static self BIBTEX()
 * @method static self BICEP()
 * @method static self BIKESHED()
 * @method static self BISON()
 * @method static self BITBAKE()
 * @method static self BLADE()
 * @method static self BLITZBASIC()
 * @method static self BLITZMAX()
 * @method static self BLUESPEC()
 * @method static self BLUESPEC_BH()
 * @method static self BOO()
 * @method static self BOOGIE()
 * @method static self BQN()
 * @method static self BRAINFUCK()
 * @method static self BRIGHTERSCRIPT()
 * @method static self BRIGHTSCRIPT()
 * @method static self BRO()
 * @method static self BROWSERSLIST()
 * @method static self C()
 * @method static self C2HS_HASKELL()
 * @method static self CABAL_CONFIG()
 * @method static self CADDYFILE()
 * @method static self CADENCE()
 * @method static self CAIRO()
 * @method static self CAMELIGO()
 * @method static self CAPN_PROTO()
 * @method static self CAP_CDS()
 * @method static self CARTOCSS()
 * @method static self CEYLON()
 * @method static self CHAPEL()
 * @method static self CHARITY()
 * @method static self CHUCK()
 * @method static self CIRCOM()
 * @method static self CIRRU()
 * @method static self CLARION()
 * @method static self CLARITY()
 * @method static self CLASSIC_ASP()
 * @method static self CLEAN()
 * @method static self CLICK()
 * @method static self CLIPS()
 * @method static self CLOJURE()
 * @method static self CLOSURE_TEMPLATES()
 * @method static self CLOUD_FIRESTORE_SECURITY_RULES()
 * @method static self CMAKE()
 * @method static self COBOL()
 * @method static self CODEQL()
 * @method static self COFFEESCRIPT()
 * @method static self COLDFUSION()
 * @method static self COLDFUSION_CFC()
 * @method static self COLLADA()
 * @method static self COMMON_LISP()
 * @method static self COMMON_WORKFLOW_LANGUAGE()
 * @method static self COMPONENT_PASCAL()
 * @method static self COOL()
 * @method static self COQ()
 * @method static self CRONTAB()
 * @method static self CRYSTAL()
 * @method static self CSON()
 * @method static self CSOUND()
 * @method static self CSOUND_DOCUMENT()
 * @method static self CSOUND_SCORE()
 * @method static self CSS()
 * @method static self CSV()
 * @method static self CUDA()
 * @method static self CUE()
 * @method static self CURRY()
 * @method static self CWEB()
 * @method static self CYCRIPT()
 * @method static self CYPHER()
 * @method static self CYTHON()
 * @method static self C_PLUSPLUS()
 * @method static self C_SHARP()
 * @method static self D()
 * @method static self D2()
 * @method static self DAFNY()
 * @method static self DARCS_PATCH()
 * @method static self DART()
 * @method static self DATAWEAVE()
 * @method static self DEBIAN_PACKAGE_CONTROL_FILE()
 * @method static self DENIZENSCRIPT()
 * @method static self DHALL()
 * @method static self DIGITAL_COMMAND_LANGUAGE()
 * @method static self DIRECTX_3D_FILE()
 * @method static self DM()
 * @method static self DOCKERFILE()
 * @method static self DOGESCRIPT()
 * @method static self DOTENV()
 * @method static self DTRACE()
 * @method static self DYLAN()
 * @method static self E()
 * @method static self EAGLE()
 * @method static self EARTHLY()
 * @method static self EASYBUILD()
 * @method static self EC()
 * @method static self ECERE_PROJECTS()
 * @method static self ECL()
 * @method static self ECLIPSE()
 * @method static self ECMARKUP()
 * @method static self EDGE()
 * @method static self EDGEQL()
 * @method static self EDITORCONFIG()
 * @method static self EIFFEL()
 * @method static self EJS()
 * @method static self ELIXIR()
 * @method static self ELM()
 * @method static self ELVISH()
 * @method static self ELVISH_TRANSCRIPT()
 * @method static self EMACS_LISP()
 * @method static self EMBERSCRIPT()
 * @method static self EQ()
 * @method static self ERLANG()
 * @method static self EUPHORIA()
 * @method static self F()
 * @method static self FACTOR()
 * @method static self FANCY()
 * @method static self FANTOM()
 * @method static self FAUST()
 * @method static self FENNEL()
 * @method static self FIGLET_FONT()
 * @method static self FILEBENCH_WML()
 * @method static self FILTERSCRIPT()
 * @method static self FIRRTL()
 * @method static self FISH()
 * @method static self FLUENT()
 * @method static self FLUX()
 * @method static self FORTH()
 * @method static self FORTRAN()
 * @method static self FORTRAN_FREE_FORM()
 * @method static self FREEBASIC()
 * @method static self FREEMARKER()
 * @method static self FREGE()
 * @method static self FUTHARK()
 * @method static self F_SHARP()
 * @method static self GAME_MAKER_LANGUAGE()
 * @method static self GAML()
 * @method static self GAMS()
 * @method static self GAP()
 * @method static self GCC_MACHINE_DESCRIPTION()
 * @method static self GDB()
 * @method static self GDSCRIPT()
 * @method static self GEDCOM()
 * @method static self GEMFILELOCK()
 * @method static self GEMINI()
 * @method static self GENERO_4GL()
 * @method static self GENERO_PER()
 * @method static self GENIE()
 * @method static self GENSHI()
 * @method static self GENTOO_EBUILD()
 * @method static self GENTOO_ECLASS()
 * @method static self GERBER_IMAGE()
 * @method static self GHERKIN()
 * @method static self GIT_ATTRIBUTES()
 * @method static self GIT_CONFIG()
 * @method static self GIT_REVISION_LIST()
 * @method static self GLEAM()
 * @method static self GLIMMER_JS()
 * @method static self GLIMMER_TS()
 * @method static self GLSL()
 * @method static self GLYPH()
 * @method static self GNUPLOT()
 * @method static self GO()
 * @method static self GODOT_RESOURCE()
 * @method static self GOLO()
 * @method static self GOSU()
 * @method static self GO_CHECKSUMS()
 * @method static self GO_MODULE()
 * @method static self GO_WORKSPACE()
 * @method static self GRACE()
 * @method static self GRADLE()
 * @method static self GRADLE_KOTLIN_DSL()
 * @method static self GRAMMATICAL_FRAMEWORK()
 * @method static self GRAPHQL()
 * @method static self GRAPHVIZ_DOT()
 * @method static self GROOVY()
 * @method static self GROOVY_SERVER_PAGES()
 * @method static self GSC()
 * @method static self G_CODE()
 * @method static self HACK()
 * @method static self HAML()
 * @method static self HANDLEBARS()
 * @method static self HAPROXY()
 * @method static self HARBOUR()
 * @method static self HASKELL()
 * @method static self HAXE()
 * @method static self HCL()
 * @method static self HIVEQL()
 * @method static self HLSL()
 * @method static self HOCON()
 * @method static self HOLYC()
 * @method static self HOON()
 * @method static self HOSTS_FILE()
 * @method static self HTML()
 * @method static self HTMLECR()
 * @method static self HTMLEEX()
 * @method static self HTMLERB()
 * @method static self HTMLPHP()
 * @method static self HTMLRAZOR()
 * @method static self HTTP()
 * @method static self HXML()
 * @method static self HY()
 * @method static self HYPHY()
 * @method static self IDL()
 * @method static self IDRIS()
 * @method static self IGNORE_LIST()
 * @method static self IGOR_PRO()
 * @method static self IMAGEJ_MACRO()
 * @method static self IMBA()
 * @method static self INFORM_7()
 * @method static self INI()
 * @method static self INK()
 * @method static self INNO_SETUP()
 * @method static self IO()
 * @method static self IOKE()
 * @method static self ISABELLE()
 * @method static self ISABELLE_ROOT()
 * @method static self J()
 * @method static self JANET()
 * @method static self JAR_MANIFEST()
 * @method static self JASMIN()
 * @method static self JAVA()
 * @method static self JAVASCRIPT()
 * @method static self JAVASCRIPTERB()
 * @method static self JAVA_PROPERTIES()
 * @method static self JAVA_SERVER_PAGES()
 * @method static self JCL()
 * @method static self JEST_SNAPSHOT()
 * @method static self JETBRAINS_MPS()
 * @method static self JFLEX()
 * @method static self JINJA()
 * @method static self JISON()
 * @method static self JISON_LEX()
 * @method static self JOLIE()
 * @method static self JQ()
 * @method static self JSON()
 * @method static self JSON5()
 * @method static self JSONIQ()
 * @method static self JSONLD()
 * @method static self JSONNET()
 * @method static self JSON_WITH_COMMENTS()
 * @method static self JULIA()
 * @method static self JULIA_REPL()
 * @method static self JUPYTER_NOTEBOOK()
 * @method static self JUST()
 * @method static self KAITAI_STRUCT()
 * @method static self KAKOUNESCRIPT()
 * @method static self KERBOSCRIPT()
 * @method static self KICAD_LAYOUT()
 * @method static self KICAD_LEGACY_LAYOUT()
 * @method static self KICAD_SCHEMATIC()
 * @method static self KOTLIN()
 * @method static self KRL()
 * @method static self KVLANG()
 * @method static self LABVIEW()
 * @method static self LARK()
 * @method static self LASSO()
 * @method static self LATTE()
 * @method static self LEAN()
 * @method static self LEAN_4()
 * @method static self LESS()
 * @method static self LEX()
 * @method static self LFE()
 * @method static self LIGOLANG()
 * @method static self LILYPOND()
 * @method static self LIMBO()
 * @method static self LIQUID()
 * @method static self LITERATE_AGDA()
 * @method static self LITERATE_COFFEESCRIPT()
 * @method static self LITERATE_HASKELL()
 * @method static self LIVESCRIPT()
 * @method static self LLVM()
 * @method static self LOGOS()
 * @method static self LOGTALK()
 * @method static self LOLCODE()
 * @method static self LOOKML()
 * @method static self LOOMSCRIPT()
 * @method static self LSL()
 * @method static self LUA()
 * @method static self LUAU()
 * @method static self M()
 * @method static self M4()
 * @method static self M4SUGAR()
 * @method static self MACAULAY2()
 * @method static self MAKEFILE()
 * @method static self MAKO()
 * @method static self MARKDOWN()
 * @method static self MARKO()
 * @method static self MASK()
 * @method static self MATHEMATICA()
 * @method static self MATLAB()
 * @method static self MAX()
 * @method static self MAXSCRIPT()
 * @method static self MCFUNCTION()
 * @method static self MDX()
 * @method static self MERCURY()
 * @method static self MERMAID()
 * @method static self MESON()
 * @method static self METAL()
 * @method static self MINID()
 * @method static self MINIYAML()
 * @method static self MINT()
 * @method static self MIRAH()
 * @method static self MIRC_SCRIPT()
 * @method static self MLIR()
 * @method static self MODELICA()
 * @method static self MODULA_2()
 * @method static self MODULA_3()
 * @method static self MODULE_MANAGEMENT_SYSTEM()
 * @method static self MOJO()
 * @method static self MONKEY()
 * @method static self MONKEY_C()
 * @method static self MOOCODE()
 * @method static self MOONSCRIPT()
 * @method static self MOTOKO()
 * @method static self MOTOROLA_68K_ASSEMBLY()
 * @method static self MOVE()
 * @method static self MQL4()
 * @method static self MQL5()
 * @method static self MTML()
 * @method static self MUF()
 * @method static self MUPAD()
 * @method static self MUSTACHE()
 * @method static self MYGHTY()
 * @method static self NANORC()
 * @method static self NASAL()
 * @method static self NASL()
 * @method static self NCL()
 * @method static self NEARLEY()
 * @method static self NEMERLE()
 * @method static self NESC()
 * @method static self NETLINX()
 * @method static self NETLINXERB()
 * @method static self NETLOGO()
 * @method static self NEWLISP()
 * @method static self NEXTFLOW()
 * @method static self NGINX()
 * @method static self NIM()
 * @method static self NIT()
 * @method static self NIX()
 * @method static self NMODL()
 * @method static self NPM_CONFIG()
 * @method static self NSIS()
 * @method static self NU()
 * @method static self NUMPY()
 * @method static self NUNJUCKS()
 * @method static self NUSHELL()
 * @method static self NWSCRIPT()
 * @method static self OASV2_JSON()
 * @method static self OASV2_YAML()
 * @method static self OASV3_JSON()
 * @method static self OASV3_YAML()
 * @method static self OBERON()
 * @method static self OBJECTIVE_C()
 * @method static self OBJECTIVE_C_PLUSPLUS()
 * @method static self OBJECTIVE_J()
 * @method static self OBJECTSCRIPT()
 * @method static self OCAML()
 * @method static self ODIN()
 * @method static self OMGROFL()
 * @method static self OOC()
 * @method static self OPA()
 * @method static self OPAL()
 * @method static self OPENAPI_SPECIFICATION_V2()
 * @method static self OPENAPI_SPECIFICATION_V3()
 * @method static self OPENCL()
 * @method static self OPENEDGE_ABL()
 * @method static self OPENQASM()
 * @method static self OPENRC_RUNSCRIPT()
 * @method static self OPENSCAD()
 * @method static self OPEN_POLICY_AGENT()
 * @method static self OPTION_LIST()
 * @method static self ORG()
 * @method static self OX()
 * @method static self OXYGENE()
 * @method static self OZ()
 * @method static self P4()
 * @method static self PACT()
 * @method static self PAN()
 * @method static self PAPYRUS()
 * @method static self PARROT()
 * @method static self PARROT_ASSEMBLY()
 * @method static self PARROT_INTERNAL_REPRESENTATION()
 * @method static self PASCAL()
 * @method static self PAWN()
 * @method static self PDDL()
 * @method static self PEGJS()
 * @method static self PEP8()
 * @method static self PERL()
 * @method static self PERL6()
 * @method static self PHP()
 * @method static self PICOLISP()
 * @method static self PIGLATIN()
 * @method static self PIKE()
 * @method static self PIP_REQUIREMENTS()
 * @method static self PKL()
 * @method static self PLANTUML()
 * @method static self PLPGSQL()
 * @method static self PLSQL()
 * @method static self POGOSCRIPT()
 * @method static self POLAR()
 * @method static self PONY()
 * @method static self PORTUGOL()
 * @method static self POSTCSS()
 * @method static self POSTSCRIPT()
 * @method static self POV_RAY_SDL()
 * @method static self POWERBUILDER()
 * @method static self POWERSHELL()
 * @method static self PRAAT()
 * @method static self PRISMA()
 * @method static self PROCESSING()
 * @method static self PROCFILE()
 * @method static self PROLOG()
 * @method static self PROMELA()
 * @method static self PROPELLER_SPIN()
 * @method static self PUG()
 * @method static self PUPPET()
 * @method static self PUREBASIC()
 * @method static self PURESCRIPT()
 * @method static self PYRET()
 * @method static self PYTHON()
 * @method static self PYTHON_CONSOLE()
 * @method static self PYTHON_TRACEBACK()
 * @method static self Q()
 * @method static self QMAKE()
 * @method static self QML()
 * @method static self QT_SCRIPT()
 * @method static self QUAKE()
 * @method static self Q_SHARP()
 * @method static self R()
 * @method static self RACKET()
 * @method static self RAGEL()
 * @method static self RAKU()
 * @method static self RAML()
 * @method static self RASCAL()
 * @method static self RBS()
 * @method static self RDOC()
 * @method static self REALBASIC()
 * @method static self REASON()
 * @method static self REASONLIGO()
 * @method static self REBOL()
 * @method static self RECORD_JAR()
 * @method static self RED()
 * @method static self REDCODE()
 * @method static self REGULAR_EXPRESSION()
 * @method static self RENDERSCRIPT()
 * @method static self RENPY()
 * @method static self RESCRIPT()
 * @method static self RESTRUCTUREDTEXT()
 * @method static self REXX()
 * @method static self REZ()
 * @method static self RING()
 * @method static self RIOT()
 * @method static self RMARKDOWN()
 * @method static self ROBOTFRAMEWORK()
 * @method static self ROC()
 * @method static self ROFF()
 * @method static self ROFF_MANPAGE()
 * @method static self RON()
 * @method static self ROUGE()
 * @method static self ROUTEROS_SCRIPT()
 * @method static self RPC()
 * @method static self RPGLE()
 * @method static self RUBY()
 * @method static self RUNOFF()
 * @method static self RUST()
 * @method static self SAGE()
 * @method static self SALTSTACK()
 * @method static self SAS()
 * @method static self SASS()
 * @method static self SCALA()
 * @method static self SCAML()
 * @method static self SCENIC()
 * @method static self SCHEME()
 * @method static self SCILAB()
 * @method static self SCSS()
 * @method static self SED()
 * @method static self SELF()
 * @method static self SHADERLAB()
 * @method static self SHELL()
 * @method static self SHELLCHECK_CONFIG()
 * @method static self SHELLSESSION()
 * @method static self SHEN()
 * @method static self SIEVE()
 * @method static self SIMPLE_FILE_VERIFICATION()
 * @method static self SINGULARITY()
 * @method static self SLASH()
 * @method static self SLICE()
 * @method static self SLIM()
 * @method static self SLINT()
 * @method static self SMALI()
 * @method static self SMALLTALK()
 * @method static self SMARTY()
 * @method static self SMITHY()
 * @method static self SMPL()
 * @method static self SMT()
 * @method static self SNAKEMAKE()
 * @method static self SOLIDITY()
 * @method static self SOURCEPAWN()
 * @method static self SPARQL()
 * @method static self SQF()
 * @method static self SQL()
 * @method static self SQLPL()
 * @method static self SQUIRREL()
 * @method static self SRECODE_TEMPLATE()
 * @method static self STAN()
 * @method static self STANDARD_ML()
 * @method static self STARLARK()
 * @method static self STATA()
 * @method static self STL()
 * @method static self STRINGTEMPLATE()
 * @method static self STYLUS()
 * @method static self SUBRIP_TEXT()
 * @method static self SUGARSS()
 * @method static self SUPERCOLLIDER()
 * @method static self SVELTE()
 * @method static self SVG()
 * @method static self SWAY()
 * @method static self SWEAVE()
 * @method static self SWIFT()
 * @method static self SWIG()
 * @method static self SYSTEMVERILOG()
 * @method static self TALON()
 * @method static self TCL()
 * @method static self TCSH()
 * @method static self TEMPL()
 * @method static self TERRA()
 * @method static self TERRAFORM_TEMPLATE()
 * @method static self TEX()
 * @method static self TEXTGRID()
 * @method static self TEXTILE()
 * @method static self TEXTMATE_PROPERTIES()
 * @method static self THRIFT()
 * @method static self TI_PROGRAM()
 * @method static self TLA()
 * @method static self TL_VERILOG()
 * @method static self TOIT()
 * @method static self TOML()
 * @method static self TSQL()
 * @method static self TSV()
 * @method static self TSX()
 * @method static self TURING()
 * @method static self TWIG()
 * @method static self TXL()
 * @method static self TYPESCRIPT()
 * @method static self TYPST()
 * @method static self UNIFIED_PARALLEL_C()
 * @method static self UNITY3D_ASSET()
 * @method static self UNIX_ASSEMBLY()
 * @method static self UNO()
 * @method static self UNREALSCRIPT()
 * @method static self URWEB()
 * @method static self V()
 * @method static self VALA()
 * @method static self VALVE_DATA_FORMAT()
 * @method static self VBA()
 * @method static self VBSCRIPT()
 * @method static self VCL()
 * @method static self VELOCITY_TEMPLATE_LANGUAGE()
 * @method static self VERILOG()
 * @method static self VHDL()
 * @method static self VIML()
 * @method static self VIM_HELP_FILE()
 * @method static self VIM_SCRIPT()
 * @method static self VIM_SNIPPET()
 * @method static self VISUAL_BASIC_60()
 * @method static self VISUAL_BASIC_NET()
 * @method static self VOLT()
 * @method static self VUE()
 * @method static self VYPER()
 * @method static self WDL()
 * @method static self WEBASSEMBLY()
 * @method static self WEBASSEMBLY_INTERFACE_TYPE()
 * @method static self WEBIDL()
 * @method static self WEB_ONTOLOGY_LANGUAGE()
 * @method static self WGSL()
 * @method static self WHILEY()
 * @method static self WIKITEXT()
 * @method static self WINDOWS_REGISTRY_ENTRIES()
 * @method static self WISP()
 * @method static self WITCHER_SCRIPT()
 * @method static self WOLLOK()
 * @method static self WORLD_OF_WARCRAFT_ADDON_DATA()
 * @method static self WREN()
 * @method static self X10()
 * @method static self XBASE()
 * @method static self XC()
 * @method static self XML()
 * @method static self XML_PROPERTY_LIST()
 * @method static self XOJO()
 * @method static self XONSH()
 * @method static self XPROC()
 * @method static self XQUERY()
 * @method static self XS()
 * @method static self XSLT()
 * @method static self XTEND()
 * @method static self YACC()
 * @method static self YAML()
 * @method static self YARA()
 * @method static self YASNIPPET()
 * @method static self YUL()
 * @method static self ZAP()
 * @method static self ZEEK()
 * @method static self ZENSCRIPT()
 * @method static self ZEPHIR()
 * @method static self ZIG()
 * @method static self ZIL()
 * @method static self ZIMPL()
 * @method static self NOASSERTION()
 */
final class Language extends Enum
{
    protected static function values(): array
    {
        return once(fn () => self::languages()
            ->mapWithKeys(fn (array $language): array => [
                $language['enum'] => match ($language['name']) {
                    'Other' => 'OTHER',
                    default => $language['name'],
                },
            ])
            ->all());
    }

    protected static function labels(): array
    {
        return once(fn () => self::languages()
            ->mapWithKeys(fn (array $language): array => [$language['enum'] => $language['name']])
            ->all());
    }

    private static function languages(): Collection
    {
        return once(
            fn () => collect(json_decode(File::get(resource_path('languages.json')), true))
                ->push(['color' => null, 'name' => 'Other', 'enum' => 'NOASSERTION'])
        );
    }

    public function color(): string
    {
        $language = self::languages()->firstWhere('name', $this->value);

        return ($language['color'] ?? null)
            ? Str::of($this->value)->slug()->prepend('lang-')
            : 'gray-300';
    }
}
