<!-- Navbar -->


<nav class="navbar navbar-expand mb-0 fixed-top shadow-0" id="top-nav">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a role="button" class="nav-link"><b><?php echo e(Auth::user()->role->name); ?></b></a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		
         <li class="nav-item">
         	<a role="button" class="nav-link" data-toggle="modal" data-target="#changePasswordModal">Change Password</a>
         </li>
         <li class="nav-item">
         	<a href="<?php echo e(route('logout')); ?>" class="nav-link"><b>Logout</b> (<?php echo e(Auth::user()->name); ?>)</a>
         </li>
     </ul>
 </nav>
 <nav class="navbar navbar-expand bg-light navbar-light" id="main-nav">
 	<div class="container-fluid">
 		<ul class="navbar-nav w-100">
 			
            <?php if(Auth::user()->role->name == 'ADMIN'): ?>
            <li class="nav-item <?php echo e(isActiveRoute('dashboard')); ?>">
                <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
            </li>
            <li class="nav-item  dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masters</a>
                <div class="dropdown-menu">
                    
                   <a class="dropdown-item <?php echo e(isActiveRoute('makes')); ?>" href="<?php echo e(route('makes')); ?>">Brands</a>
                   <a  class="dropdown-item <?php echo e(isActiveRoute('models')); ?>" href="<?php echo e(route('models')); ?>">Models</a>
                
                <a  class="dropdown-item <?php echo e(isActiveRoute('categories')); ?>" href="<?php echo e(route('categories')); ?>">Category</a>

                <a  class="dropdown-item <?php echo e(isActiveRoute('catremarks')); ?>" href="<?php echo e(route('catremarks')); ?>">Category Remarks</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('expensecategories')); ?>" href="<?php echo e(route('expensecategories')); ?>">Expense Category</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('expenses')); ?>" href="<?php echo e(route('expenses')); ?>">Expenses</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('incomecategories')); ?>" href="<?php echo e(route('incomecategories')); ?>">Income Category</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('incomes')); ?>" href="<?php echo e(route('incomes')); ?>">Incomes</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('loyalcustomer')); ?>" href="<?php echo e(route('loyalcustomer')); ?>">Find Customer </a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('employees')); ?>" href="<?php echo e(route('employees')); ?>">Employees </a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('vendors')); ?>" href="<?php echo e(route('vendors')); ?>">Vendors </a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('purchases')); ?>" href="<?php echo e(route('purchases')); ?>">Purchase Entry </a>
                </div>
            </li>
          
 			
            
          
            <li class="nav-item <?php echo e(isActiveRoute('jobcards')); ?>">
                <a class="nav-link" href="<?php echo e(route('jobcards')); ?>">Jobcards</a>
            </li>
        <li class="nav-item <?php echo e(isActiveRoute('sales')); ?>">
            <a class="nav-link" href="<?php echo e(route('sales')); ?>">Sales</a>
        </li>
        

            
            
            <li class="nav-item  dropdown <?php echo e(areActiveRoutes(['campaigns-report','services-report'])); ?>">
               <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
               <div class="dropdown-menu">
                 
                 <a class="dropdown-item <?php echo e(isActiveRoute('return_report')); ?>" href="<?php echo e(route('return_report')); ?>">Return Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('delivery-report')); ?>" href="<?php echo e(route('delivery-report')); ?>">Delivery Report</a>
                 

                  <a class="dropdown-item <?php echo e(isActiveRoute('expenses-report')); ?>" href="<?php echo e(route('expenses-report')); ?>">Expense Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('stockreport')); ?>" href="<?php echo e(route('stockreport')); ?>">Stock Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('balance_sheet')); ?>" href="<?php echo e(route('balance_sheet')); ?>">Balance Sheet Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('customer_report')); ?>" href="<?php echo e(route('customer_report')); ?>">Download Customer List</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('sale_credits')); ?>" href="<?php echo e(route('sale_credits')); ?>">Sale Credit Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('credits')); ?>" href="<?php echo e(route('credits')); ?>">Credit Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('paycredit-report')); ?>" href="<?php echo e(route('paycredit-report')); ?>">PayCredit Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('purchasecredits')); ?>" href="<?php echo e(route('purchasecredits')); ?>">Purchase Vendor-Credit Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('payvendorcredit-report')); ?>" href="<?php echo e(route('payvendorcredit-report')); ?>">PayVendorCredit Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('download')); ?>" href="<?php echo e(route('download')); ?>">Download Import Template</a>
                  
                  
              </div>
          </li>
          
          <?php elseif(Auth::user()->role->name == 'SERVICE'): ?>
          <li class="nav-item <?php echo e(isActiveRoute('redeem')); ?>">
           <a class="nav-link" href="<?php echo e(route('redeem')); ?>">Redeem</a>
       </li>
       <?php elseif(Auth::user()->role->name == 'SUPERADMIN'): ?>
       <li class="nav-item <?php echo e(isActiveRoute('companies')); ?>">
           <a class="nav-link" href="<?php echo e(route('companies')); ?>">Companies</a>
       </li>
       <?php else: ?>
       <li class="nav-item <?php echo e(isActiveRoute('dashboard')); ?>">
           <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
       </li>
       <?php endif; ?>
   </ul>
</div>
</nav>

<!-- End of navbar --><?php /**PATH C:\laragon\www\sizcom\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>