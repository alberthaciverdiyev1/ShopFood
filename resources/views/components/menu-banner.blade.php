<div class="mx-auto px-24">
    <p class="font-bold">@lang("Menu")</p>

    <div class="mt-4 flex flex-wrap gap-3">

        <div class="bg-[var(--color-warning)] rounded-2xl px-7 py-3">
            <a href="{{ route('basket.list') }}">
                <span class="text-center text-white font-bold">@lang("Order")</span>
            </a>
        </div>

        <div class="bg-[var(--color-warning)] rounded-2xl px-7 py-3">
            <a href="{{ route('profile') }}">
                <span class="text-center text-white font-bold">@lang("Order history")</span>
            </a>
        </div>

        <div class="bg-[var(--color-warning)] rounded-2xl px-7 py-3">
            <a href="{{ route('privacy-policy.home') }}">
                <span class="text-center text-white font-bold">@lang("Privacy and Policy")</span>
            </a>
        </div>

        <div class="bg-[var(--color-warning)] rounded-2xl px-7 py-3">
            <span class="text-center text-white font-bold">@lang("Support")</span>
        </div>

        <div class="bg-[var(--color-warning)] rounded-2xl px-7 py-3">
            <a href="{{ route('trading_rules.home') }}">
                <span class="text-center text-white font-bold">@lang("Trading rules")</span>
            </a>
        </div>

    </div>
</div>
