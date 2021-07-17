
require('./bootstrap');
window.Vue = require('vue');
window.bus = new Vue();
export const bus = new Vue();
import vSelect from 'vue-select';
import swal from 'sweetalert';
import floatingScroll from 'floating-scroll';


Vue.component('v-select', vSelect);
Vue.component('find-customer', require('./components/admin/FindCustomer.vue').default);
Vue.component('add-jobcard', require('./components/admin/AddJobcard.vue').default);

Vue.component('return-purchase', require('./components/admin/ReturnPurchase.vue').default);
Vue.component('return-sale', require('./components/admin/ReturnSale.vue').default);


Vue.component('add-recovery', require('./components/admin/AddRecovery.vue').default);
Vue.component('assign-technician', require('./components/admin/TechnicianAssign.vue').default);
Vue.component('followup-calls', require('./components/admin/FollowupCalls.vue').default);
Vue.component('jobcards', require('./components/admin/Jobcards.vue').default);


Vue.component('add-user', require('./components/admin/AddUser.vue').default);
Vue.component('users', require('./components/admin/Users.vue').default);


Vue.component('add-service', require('./components/admin/AddService.vue').default);
Vue.component('services', require('./components/admin/Services.vue').default);

Vue.component('add-category', require('./components/admin/AddCategory.vue').default);
Vue.component('categories', require('./components/admin/Categories.vue').default);

Vue.component('add-sale', require('./components/admin/AddSale.vue').default);
Vue.component('today-sales', require('./components/admin/Sales.vue').default);

Vue.component('add-sale_order', require('./components/admin/AddSaleOrder.vue').default);
Vue.component('today-sale_orders', require('./components/admin/SaleOrders.vue').default);

Vue.component('add-invoice', require('./components/admin/AddInvoice.vue').default);
Vue.component('today-invoices', require('./components/admin/Invoices.vue').default);


Vue.component('payments', require('./components/admin/Payments.vue').default);
Vue.component('add-payment', require('./components/admin/AddPayment.vue').default);

Vue.component('purchasepayments', require('./components/admin/PurchasePayments.vue').default);
Vue.component('add-purchasepayment', require('./components/admin/AddPurchasePayment.vue').default);

Vue.component('rec_payments', require('./components/admin/RecPayments.vue').default);
Vue.component('add-rec_payment', require('./components/admin/AddRecPayment.vue').default);

Vue.component('add-accessory', require('./components/admin/AddAccessory.vue').default);
Vue.component('accessories', require('./components/admin/Accessories.vue').default);

Vue.component('add-catremark', require('./components/admin/AddCatRemark.vue').default);
Vue.component('catremarks', require('./components/admin/CatRemarks.vue').default);

Vue.component('add-expensecategory', require('./components/admin/AddExpenseCategory.vue').default);
Vue.component('expensecategories', require('./components/admin/ExpenseCategories.vue').default);

Vue.component('add-student', require('./components/admin/AddStudent.vue').default);
Vue.component('students', require('./components/admin/Students.vue').default);

Vue.component('add-vendor', require('./components/admin/AddVendor.vue').default);
Vue.component('vendors', require('./components/admin/Vendors.vue').default);

Vue.component('add-product', require('./components/admin/AddProduct.vue').default);
Vue.component('products', require('./components/admin/Products.vue').default);


Vue.component('add-expense', require('./components/admin/AddExpense.vue').default);
Vue.component('expenses', require('./components/admin/Expenses.vue').default);

Vue.component('add-purchase', require('./components/admin/AddPurchase.vue').default);
Vue.component('purchases', require('./components/admin/Purchases.vue').default);

Vue.component('add-incomecategory', require('./components/admin/AddIncomeCategory.vue').default);
Vue.component('incomecategories', require('./components/admin/IncomeCategories.vue').default);

Vue.component('add-income', require('./components/admin/AddIncome.vue').default);
Vue.component('incomes', require('./components/admin/Incomes.vue').default);

Vue.component('add-make', require('./components/admin/AddMake.vue').default);
Vue.component('makes', require('./components/admin/Makes.vue').default);

Vue.component('add-employee', require('./components/admin/AddEmployee.vue').default);
Vue.component('employees', require('./components/admin/Employees.vue').default);

Vue.component('add-model', require('./components/admin/AddModel.vue').default);
Vue.component('models', require('./components/admin/Models.vue').default);
//report
Vue.component('expense-report', require('./components/reports/expense-report.vue').default);
Vue.component('return-report', require('./components/reports/return-report.vue').default);
Vue.component('balance-sheet', require('./components/reports/balance-sheet.vue').default);
Vue.component('delivery-report', require('./components/reports/delivery-report.vue').default);
Vue.component('services-report', require('./components/reports/services-report.vue').default);
Vue.component('paycredit-report', require('./components/reports/paycredit-report.vue').default);
Vue.component('payvendorcredit-report', require('./components/reports/payvendorcredit-report.vue').default);
Vue.component('invoice-report', require('./components/reports/invoice-report.vue').default);
Vue.component('closing-report', require('./components/reports/closing-report.vue').default);
Vue.component('purchase-report', require('./components/reports/purchase-report.vue').default);
Vue.component('item-report', require('./components/reports/item-report.vue').default);


Vue.component('stock-report', require('./components/reports/stock-report.vue').default);
Vue.component('edit-stock', require('./components/admin/EditStock.vue').default);

Vue.component('return_item', require('./components/reports/return_item.vue').default);

Vue.component('change-password', require('./components/admin/ChangePassword.vue').default);

Vue.component('companies', require('./components/superadmin/Companies.vue').default);
Vue.component('add-company', require('./components/superadmin/AddCompany.vue').default);

Vue.component('credits', require('./components/admin/Credits.vue').default);

Vue.component('sale_credits', require('./components/admin/SaleCredits.vue').default);

Vue.component('accoption', require('./components/admin/AccOption.vue').default);

Vue.component('purchasecredits', require('./components/admin/PurchaseCredits.vue').default);

Vue.component('today-report', require('./components/reports/TodayReport.vue').default);

Vue.component('pay-balance-invoice', require('./components/admin/PayBalanceInvoice.vue').default);
Vue.component('pay-balance-receipt', require('./components/admin/PayBalanceReceipt.vue').default);
Vue.component('pay-balance-purchase', require('./components/admin/PayBalancePurchase.vue').default);


const app = new Vue({
    el: '#app'
});
