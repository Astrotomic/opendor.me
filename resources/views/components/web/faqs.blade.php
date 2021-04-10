<div class="bg-white">
    <div class="py-8 px-4 mx-auto max-w-7xl divide-y-2 divide-gray-200 sm:py-16 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900">
            Frequently Asked Questions
        </h2>
        <div class="pt-10 mt-6">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-2">
                @foreach($faqs() as $faq)
                    <div>
                        <dt class="text-lg font-medium leading-6 text-gray-900">
                            {{ $faq->question }}
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            {!! \Illuminate\Support\Str::markdown($faq->answer) !!}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
