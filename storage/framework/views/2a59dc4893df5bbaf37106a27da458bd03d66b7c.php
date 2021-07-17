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
 			
            <?php if(Auth::user()->role->name == 'ADMIN' ): ?>
          
            <li class="nav-item  dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masters</a>
                <div class="dropdown-menu">
                <a  class="dropdown-item <?php echo e(isActiveRoute('expensecategories')); ?>" href="<?php echo e(route('expensecategories')); ?>">Expense Types</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('expenses')); ?>" href="<?php echo e(route('expenses')); ?>">Expenses</a>
              
                <a  class="dropdown-item <?php echo e(isActiveRoute('employees')); ?>" href="<?php echo e(route('employees')); ?>">Employees </a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('vendors')); ?>" href="<?php echo e(route('vendors')); ?>">Vendors </a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('products')); ?>" href="<?php echo e(route('products')); ?>">Products </a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('purchases')); ?>" href="<?php echo e(route('purchases')); ?>">Purchase Entry </a>
                </div>
            </li>
          

          
            
        
        
         <li class="nav-item <?php echo e(isActiveRoute('invoices')); ?>">
            <a class="nav-link" href="<?php echo e(route('invoices')); ?>">Invoices</a>
        </li>
      
            <li class="nav-item  dropdown <?php echo e(areActiveRoutes(['campaigns-report','services-report'])); ?>">
               <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
               <div class="dropdown-menu">
                  <!-- <a class="dropdown-item <?php echo e(isActiveRoute('today-report')); ?>" href="<?php echo e(route('today-report')); ?>">Today Report</a> -->
                   <a class="dropdown-item <?php echo e(isActiveRoute('today-report')); ?>" href="<?php echo e(route('today-report')); ?>">Today Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('item-report')); ?>" href="<?php echo e(route('item-report')); ?>">Item Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('expenses-report')); ?>" href="<?php echo e(route('expenses-report')); ?>">Expense Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('stockreport')); ?>" href="<?php echo e(route('stockreport')); ?>">Stock Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('invoices-report')); ?>" href="<?php echo e(route('invoices-report')); ?>">Invoice Report</a>
                   <a class="dropdown-item <?php echo e(isActiveRoute('pay_balance_invoices')); ?>" href="<?php echo e(route('pay_balance_invoices')); ?>">Payment Balance Invoices</a>
                      <a class="dropdown-item <?php echo e(isActiveRoute('purchase-report')); ?>" href="<?php echo e(route('purchase-report')); ?>">Purchase Report</a> 
                                <a class="dropdown-item <?php echo e(isActiveRoute('closing-report')); ?>" href="<?php echo e(route('closing-report')); ?>">Closing Report</a>
                  
                   
                  <a class="dropdown-item <?php echo e(isActiveRoute('purchasecredits')); ?>" href="<?php echo e(route('purchasecredits')); ?>">Purchase Vendor-Credit Report</a>
                  
              </div>
          </li>
          <li class="nav-item ">
                <a class="nav-link" href="<?php echo e(route('closing')); ?>">Counter Cash</a>
            </li>
             <li class="nav-item ">
                <a class="nav-link" href="<?php echo e(route('today-report')); ?>">Today Report</a>
            </li>
          
          <?php elseif(Auth::user()->role->name == 'BILLING'): ?>
             
            <li class="nav-item  dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masters</a>
                <div class="dropdown-menu">
                <a  class="dropdown-item <?php echo e(isActiveRoute('expensecategories')); ?>" href="<?php echo e(route('expensecategories')); ?>">Expense Category</a>
                <a  class="dropdown-item <?php echo e(isActiveRoute('expenses')); ?>" href="<?php echo e(route('expenses')); ?>">Expenses</a>
          
                
                </div>
            </li>

          
          
        
        
         <li class="nav-item <?php echo e(isActiveRoute('invoices')); ?>">
            <a class="nav-link" href="<?php echo e(route('invoices')); ?>">Invoices</a>
        </li>
      
            <li class="nav-item  dropdown <?php echo e(areActiveRoutes(['campaigns-report','services-report'])); ?>">
               <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
               <div class="dropdown-menu">
                  <!-- <a class="dropdown-item <?php echo e(isActiveRoute('today-report')); ?>" href="<?php echo e(route('today-report')); ?>">Today Report</a> -->
                 
                  <a class="dropdown-item <?php echo e(isActiveRoute('stockreport')); ?>" href="<?php echo e(route('stockreport')); ?>">Stock Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('invoices-report')); ?>" href="<?php echo e(route('invoices-report')); ?>">Invoice Report</a>
                   <a class="dropdown-item <?php echo e(isActiveRoute('closing-report')); ?>" href="<?php echo e(route('closing-report')); ?>">Closing Report</a>
                  <a class="dropdown-item <?php echo e(isActiveRoute('expenses-report')); ?>" href="<?php echo e(route('expenses-report')); ?>">Expense Report</a>
                   <a class="dropdown-item <?php echo e(isActiveRoute('pay_balance_invoices')); ?>" href="<?php echo e(route('pay_balance_invoices')); ?>">Payment Balance Invoices</a>
                   
                 
              </div>
          </li>
          <li class="nav-item ">
                <a class="nav-link" href="<?php echo e(route('closing')); ?>">Counter Cash</a>
            </li>
          
       <?php endif; ?>
   </ul>
</div>
</nav>

<!-- End of navbar --><?php /**PATH C:\laragon\www\cake\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>