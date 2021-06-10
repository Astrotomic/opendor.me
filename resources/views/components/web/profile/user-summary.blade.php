<p class="text-gray-700">
    <span class="font-medium text-gray-900">{{ $user->display_name }}</span> has contributed to <span class="font-medium text-gray-900">{{ $user->contributions_count }}</span> different repositories.
    <br/>
    These repositories have {!! $languages->map(fn(\App\Enums\Language $l) => '<span class="font-medium text-gray-900">'.$l->label.'</span>')->join(', ', ' and ') !!} as their primary {{ \Illuminate\Support\Str::plural('language', $languages->count()) }} - most contributions were made to repositories using <span class="font-medium text-gray-900">{{ $user->primary_language }}</span> as primary language.
    @if($user->repositories()->exists())
        <br/>
        They publish open-source repositories using their own <span class="font-medium text-gray-900">{{ $user->name }}</span> nickname.
    @endif
    @if($organizations->isNotEmpty())
        <br/>
        In addition, they are also a member of {!! $organizations->map(fn(\App\Models\Organization $organization) => '<span class="font-medium text-gray-900">'.($organization->display_name).'</span>')->join(', ', ' and ') !!} {{ \Illuminate\Support\Str::plural('organization', $organizations->count()) }}, and have contributed to their open-source repositories.
    @endif
</p>
