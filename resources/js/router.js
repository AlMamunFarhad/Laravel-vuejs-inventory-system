import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/auth/Login.vue';
import Logout from './components/auth/Logout.vue';
import Register from './components/auth/Register.vue';
import ForgotPassowrd from './components/auth/ForgotPassword.vue';
import Home from './components/Home.vue';
// End Ahthentication
// Employee Component
import employees from './components/employee/employees.vue';
import CreateEmployee from './components/employee/create.vue';
import EditEmployee from './components/employee/EditEmployee.vue';
// End Employee
// Supplier Component
import CreateSupplier from './components/supplier/Create.vue';
import Suppliers from './components/supplier/suppliers.vue';
import EditSupplier from './components/supplier/EditSupplier.vue';
// End Supplier
// Customer Component
import CreateCustomer from './components/customer/CreateCustomer.vue';
import EditCustomer from './components/customer/EditCostomer.vue';
import Customers from './components/customer/Customers.vue';
// End Customer
// Category Component
import Categories from './components/category/Categories.vue';
import CreateCategory from './components/category/CreateCategory.vue';
import EditCategory from './components/category/EditCategory.vue';
// End Category
// Product Component
import Products from './components/product/Products.vue';
import CreateProduct from './components/product/CreateProduct.vue';
import EditProduct from './components/product/EditProduct.vue';
import Stock from './components/product/Stock.vue';
import EditStock from './components/product/EditStock.vue';
// End Product
// Expense Component
import Expenses from './components/expense/Expenses.vue';
import CreateExpense from './components/expense/CreateExpense.vue';
import EditExpense from './components/expense/EditExpense.vue';
// End Expense
// Salary Component
import AllEmployeeSalary from './components/salary/All_Employee_Salary.vue';
import Salaries from './components/salary/Salaries.vue';
import CreateSalary from './components/salary/CreateSalary.vue';
import EditSalary from './components/salary/EditSalary.vue';
import ViewSalaray from './components/salary/View_Salary.vue';
// End Salary
// Print of Pos Component
import PrintOfSale from './components/pos/PrintOfSale.vue';



const routes = [
    { path: '/', component: Login },
    { path: '/logout', component: Logout  },
    { path: '/register', component: Register},
    { path: '/forgot-password', component: ForgotPassowrd },
    { path: '/home', component: Home},
    // Employee Routes
    { path: '/employees', component: employees },
    { path: '/store-employee', component: CreateEmployee },
    { path: '/edit-employee/:id', component: EditEmployee, name: 'edit-employee' },
    // Supplier Routes
    { path: '/store-supplier', component: CreateSupplier },
    { path: '/suppliers', component: Suppliers },
    { path: '/edit-supplier/:id', component: EditSupplier, name: 'edit-supplier' },
    // Customer Routes
    {path: '/store-customer', component: CreateCustomer},
    {path: '/edit-customer/:id', component: EditCustomer, name: 'edit-customer'},
    {path: '/customers', component: Customers},
    // Category Routes
    { path: '/categories', component: Categories },
    { path: '/store-category', component: CreateCategory },
    { path: '/edit-category/:id', component: EditCategory, name: 'edit-category' },
    // Product Routes
    { path: '/products', component: Products },
    { path: '/store-product', component: CreateProduct },
    { path: '/edit-product/:id', component: EditProduct, name: 'edit-product' },
    { path: '/stock', component: Stock },
    {path: '/edit-stock/:id', component: EditStock, name: 'edit-stock'},
    // Expense Routes
    { path: '/expenses', component: Expenses },
    { path: '/store-expense', component: CreateExpense },
    { path: '/edit-expense/:id', component: EditExpense, name: 'edit-expense' },
    // Salary Routes
    {path: '/given-salary', component: AllEmployeeSalary},
    {path: '/given-salary/:id', component: CreateSalary, name: 'pay-salary'},
    {path: '/salaries', component: Salaries},
    {path:'/edit-salary/:id', component: EditSalary, name: 'edit-salary'},
    {path:'/view-salary/:id', component: ViewSalaray, name: 'view-salary'},
    // Print Routes
    {path: '/pos', component: PrintOfSale},
];
const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;

