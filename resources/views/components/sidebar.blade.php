<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">CASHWAVE</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">CW</a>
        </div>
        <ul class="sidebar-menu">
           <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link "><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>

            </li>

            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link "><i class="fas fa-fire"></i><span>Users</span></a>



            </li>

            <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link "><i
                        class="fas fa-fire"></i><span>Categories</span></a>

            </li>

            <li class="nav-item ">
                <a href="{{ route('product.index') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('product.index') }}">All Products</a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('order.index') }}" class="nav-link "><i
                        class="fas fa-fire"></i><span>Orders</span></a>

            </li>

    </aside>
</div>