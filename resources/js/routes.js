import order from "./components/order/order";


let login= require('./components/auth/login.vue').default;
let register= require('./components/auth/register.vue').default;
let forget= require('./components/auth/forget.vue').default;
let home= require('./components/home.vue').default;
let logout= require('./components/auth/logout.vue').default;

//    Employee Component

let storeemployee= require('./components/employee/create.vue').default;
let employee= require('./components/employee/index.vue').default;
let editemployee= require('./components/employee/edit.vue').default;

//    Supplier Component

let storesupplier= require('./components/supplier/create.vue').default;
let supplier= require('./components/supplier/index.vue').default;
let editsupplier= require('./components/supplier/edit.vue').default;

//    Category Component

let storecategory= require('./components/category/create.vue').default;
let category= require('./components/category/index.vue').default;
let editcategory= require('./components/category/edit.vue').default;

//    Product Component

let storeproduct=require('./components/product/create.vue').default;
let product=require('./components/product/index.vue').default;
let editproduct=require('./components/product/edit.vue').default;

//    Expense Component

let storeexpense=require('./components/expense/create.vue').default;
let expense=require('./components/expense/index.vue').default;
let editexpense=require('./components/expense/edit.vue').default;

//    Salary Component

let paysalary=require('./components/salary/create.vue').default;
let salary=require('./components/salary/all_employee.vue').default;
let allsalary=require('./components/salary/index.vue').default;
let viewsalary=require('./components/salary/view.vue').default;
let editsalary=require('./components/salary/edit.vue').default;

//    Stock Component

let stock=require('./components/product/stock.vue').default;
let editstock=require('./components/product/edit-stock.vue').default;

//    Stock Component

let customer=require('./components/customer/index.vue').default;
let editcustomer=require('./components/customer/edit.vue').default;
let storecustomer=require('./components/customer/create.vue').default;

//    POS Component

let pos=require('./components/pos/pointofsale.vue').default;

//    Order Component

let allorder=require('./components/order/order.vue').default;
let vieworder=require('./components/order/vieworder.vue').default;
let searchorder=require('./components/order/searchorder.vue').default;

export const routes=[
    { path: '/', component: login, name: 'login'},
    { path: '/register', component: register, name: 'register'},
    { path: '/forget', component: forget, name: 'forget'},
    { path: '/home', component: home, name: 'home'},
    { path: '/logout', component: logout, name: 'logout'},

    //  Employee Routes

    { path: '/store-employee', component: storeemployee, name: 'store-employee'},
    { path: '/employee', component: employee, name: 'employee'},
    { path: '/editemployee/:id', component: editemployee, name: 'editemployee'},

    //  Supplier Routes

    { path: '/store-supplier', component: storesupplier, name: 'store-supplier'},
    { path: '/supplier', component: supplier, name: 'supplier'},
    { path: '/editsupplier/:id', component: editsupplier, name: 'editsupplier'},

    //  Category Routes

    { path: '/store-category', component: storecategory, name: 'store-category'},
    { path: '/category', component: category, name: 'category'},
    { path: '/editcategory/:id', component: editcategory, name: 'editcategory'},

    //  Product Routes

    {path: '/store-product', component: storeproduct, name: 'storeproduct'},
    {path: '/product', component: product, name: 'product'},
    {path: '/edit-product/:id', component: editproduct, name: 'editproduct'},

    //  Expense Routes

    {path: '/store-expense', component: storeexpense, name: 'storeproduct'},
    {path: '/expense', component: expense, name: 'product'},
    {path: '/edit-expense/:id', component: editexpense, name: 'editexpense'},

    //  Salary Routes

    {path: '/given-salary', component: salary, name: 'salary'},
    {path: '/pay-salary/:id', component: paysalary, name: 'paysalary'},
    {path: '/salary', component: allsalary, name: 'allsalary'},
    {path: '/viewsalary/:id', component: viewsalary, name: 'viewsalary'},
    {path: '/edit-salary/:id', component: editsalary, name: 'editsalary'},

    //  Stock Routes

    {path: '/stock', component: stock, name: 'stock'},
    {path: '/edit-stock/:id', component: editstock, name: 'editstock'},

    //  Customer Routes

    {path: '/store-customer', component: storecustomer, name: 'storecustomer'},
    {path: '/customer', component: customer, name: 'customer'},
    {path: '/edit-customer/:id', component: editcustomer, name: 'editcustomer'},

    //  POS Routes

    {path: '/pos', component: pos, name: 'pos'},

    //  All Orders Routes

    {path: '/allorder', component: allorder, name: 'allorders'},
    {path: '/vieworder/:id', component: vieworder, name: 'vieworder'},
    {path: '/searchorder', component: searchorder, name: 'searchorder'},
]
