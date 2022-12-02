<ul class="nav">
    <li class="nav-item">
        <a @class(["nav-link", "nav-link_active" => Request::is('app/main')]) href="/app/main">User</a>
    </li>
    <li class="nav-item">
        <a @class(["nav-link", "nav-link_active" => Request::is('app/bindings')]) href="/app/bindings">Bindings</a>
    </li>
    <li class="nav-item">
        <a @class(["nav-link", "nav-link_active" => Request::is('app/settings')]) href="/app/settings">Settings</a>
    </li>
    <li class="nav-item">
        <form method="POST" action="/auth/logout">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </li>
</ul>
