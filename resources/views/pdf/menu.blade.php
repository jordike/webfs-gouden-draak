<!DOCTYPE html>

<html lang="nl">

    <head>
        <meta charset="UTF-8">

        <title>Menu</title>

        <style>
            body {
                background: #f8fafc;
                font-family: 'Georgia', serif;
                color: #1a202c;
            }

            .menu-bg {
                background: #fff;
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
                border-radius: 1rem;
                padding: 2.5rem 2rem;
                max-width: 700px;
                margin: 2rem auto;
            }

            .logo {
                display: block;
                margin: 0 auto 2rem auto;
                max-width: 180px;
                height: auto;
            }

            .menu-title {
                margin-bottom: 2rem;
                border-bottom: 4px solid #ca8a04;
                padding-bottom: 1rem;
                text-align: center;
                font-size: 2.25rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #854d0e;
            }

            .category {
                margin-bottom: 3rem;
            }

            .category-title {
                margin-bottom: 1rem;
                margin-top: 2.5rem;
                border-bottom: 1px solid #fef08a;
                padding-bottom: 0.5rem;
                font-size: 1.5rem;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #ca8a04;
            }

            .item {
                margin-bottom: 1.5rem;
            }

            .item-header {
                display: flex;
                align-items: baseline;
                justify-content: space-between;
                font-size: 1.125rem;
                font-weight: 600;
            }

            .item-id {
                margin-right: 0.5rem;
                font-size: 0.75rem;
                color: #9ca3af;
            }

            .item-price {
                white-space: nowrap;
                font-weight: bold;
                color: #854d0e;
            }

            .item-description {
                margin-left: 0.5rem;
                margin-top: 0.25rem;
                font-size: 0.875rem;
                font-style: italic;
                color: #6b7280;
            }

            .item-options {
                margin-left: 1.5rem;
                margin-top: 0.5rem;
                font-size: 0.875rem;
                color: #374151;
            }

            .option-row {
                display: flex;
                justify-content: space-between;
            }

            .option-price {
                white-space: nowrap;
            }

            @media print {

                body,
                .menu-bg {
                    background: #fff !important;
                    box-shadow: none !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="menu-bg">
            <img class="logo" src="{{ public_path('assets/img/dragon-large.png') }}" alt="Logo" />

            <h1 class="menu-title">Menu</h1>

            @foreach ($categories as $category)
                <div class="category">
                    <h2 class="category-title">{!! $category->name !!}</h2>

                    @foreach ($category->items as $item)
                        <div class="item">
                            <div class="item-header">
                                <span>
                                    <span class="item-id">#{{ $item->id }}</span>
                                    {!! $item->name !!}
                                </span>

                                <span class="item-price">&euro; {{ number_format($item->price, 2, ',', '.') }}</span>
                            </div>

                            @if (!empty($item->description))
                                <div class="item-description">
                                    {!! $item->description !!}
                                </div>
                            @endif

                            @if (isset($item->options) && count($item->options))
                                <div class="item-options">
                                    @foreach ($item->options as $option)
                                        <div class="option-row">
                                            <span>- {{ $option->name }}</span>
                                            <span class="option-price">&euro; {{ number_format($option->price, 2, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </body>

</html>
