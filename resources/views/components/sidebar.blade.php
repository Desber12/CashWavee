<div class="w-64 h-screen bg-white border-r">
    <div class="p-6 font-bold text-xl text-gray-700">
        CASHWAVE
    </div>
    <ul class="space-y-2 mt-6">
        <li>
            <a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-gray-100 text-gray-800">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('user.index') }}" class="block py-2 px-4 hover:bg-gray-100 text-gray-800">
                User 
            </a>
        </li>
        <li>
            <a href="{{ route('product.index') }}" class="block py-2 px-4 hover:bg-gray-100 text-gray-800">
                Product
            </a>
        </li>
        <li>
            <a href="{{ route('order.index') }}" class="block py-2 px-4 hover:bg-gray-100 text-gray-800">
                Order
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" class="block py-2 px-4 hover:bg-red-100 text-red-600">
                Logout
            </a>
        </li>
    </ul>
</div>

