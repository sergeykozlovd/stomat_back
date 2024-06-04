<header>
    <div class="d-flex flex-column flex-md-row align-items-center p-2 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
            <span class="fs-4">Pricing example</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">

            <a class="me-3 py-2 link-body-emphasis text-decoration-none"
               href="{{ route(\App\RouteName::CATEGORY_SHOW) }}">Категории</a>

            <a class="me-3 py-2 link-body-emphasis text-decoration-none"
               href="{{ route(\App\RouteName::ADVERT_SHOW) }}">Объявления</a>

            <a class="me-3 py-2 link-body-emphasis text-decoration-none"
               href="{{ route(\App\RouteName::ADVERT_SHOW) }}">Объявления</a>

            <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/">Home</a>
            <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/users">Users</a>
            <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/logout">Logout</a>
        </nav>
    </div>
</header>

