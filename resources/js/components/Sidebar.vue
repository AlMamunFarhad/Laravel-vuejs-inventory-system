<template>
          <nav id="sidebar" class="sidebar js-sidebar">
                
                <div class="sidebar-content js-simplebar">
                    <router-link class="sidebar-brand" to="/home">
                        <span class="align-middle">Dashboard</span>
                    </router-link>
    
                    <ul class="sidebar-nav">
                        <li class="sidebar-header">
                            Employee
                        </li>
    
                        <li class="sidebar-item active">
                            <router-link class="sidebar-link" to="/store-employee">
                                <i class="align-middle" data-feather="user"></i> <span
                                    class="align-middle">Add Employee</span>
                            </router-link>
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/employees">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Employees</span>
                            </router-link>
                        </li>
                        <li class="sidebar-header">
                            Suppliers
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/store-supplier">
                                <i class="align-middle" data-feather="user"></i> <span
                                    class="align-middle">Add Supplier</span>
                            </router-link>
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/suppliers">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Suppliers</span>
                            </router-link>
                        </li>
                        <li class="sidebar-header">
                            Categories
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/store-category">
                                <i class="align-middle" data-feather="user"></i> <span
                                    class="align-middle">Add Category</span>
                            </router-link>
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/categories">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Suppliers</span>
                            </router-link>
                        </li>
                        <li class="sidebar-header">
                            Products
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/store-product">
                                <i class="align-middle" data-feather="user"></i> <span
                                    class="align-middle">Add Product</span>
                            </router-link>
                        </li>
    
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/products">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Products</span>
                            </router-link>
                        </li>
                        <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/logout">
                                <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Sign
                                    Out</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </nav>
</template>
<script>
export default {}
</script>