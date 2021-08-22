{{-- select_from_array column --}}
@php
    $values = data_get($entry, $column['name']);
    $list = [];
    if ($values !== null) {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (! is_null($value)) {
                    $list[$key] = $column['options'][(string)$value] ?? $value;
                }
            }
        } else {
            $value = $column['options'][(string)$values] ?? $values;
            $list[(string)$values] = $value;
        }
    }


    $column['escaped'] = $column['escaped'] ?? true;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
@endphp

<span>
    @if(!empty($list))
        {{ $column['prefix'] }}
        @foreach($list as $key => $text)
            @php
                $related_key = $key;
            @endphp

            <span class="d-inline-flex">
                @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
                    @if($column['escaped'])
                        {{ $text }}
                    @else
                        {!! $text !!}
                    @endif
                @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

                @if(!$loop->last), @endif
            </span>
        @endforeach
        {{ $column['suffix'] }}
    @else
        -
    @endif
</span>
