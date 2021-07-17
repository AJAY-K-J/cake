<!-- Navbar -->


<nav class="navbar navbar-expand mb-0 fixed-top shadow-0" id="top-nav">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a role="button" class="nav-link"><b>{{ Auth::user()->role->name }}</b></a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		
         <li class="nav-item">
         	<a role="button" class="nav-link" data-toggle="modal" data-target="#changePasswordModal">Change Password</a>
         </li>
         <li class="nav-item">
         	<a href="{{ route('logout') }}" class="nav-link"><b>Logout</b> ({{ Auth::user()->name }})</a>
         </li>
     </ul>
 </nav>
 <nav class="navbar navbar-expand bg-light navbar-light" id="main-nav">
 	<div class="container-fluid">
 		<ul class="navbar-nav w-100">
 			{{-- <li class="nav-item {{ areActiveRoutes(['admin.home','cc.home','service.home']) }}">
 				<a class="nav-link" href="{{ route('home') }}">Home</a>
 			</li> --}}
            @if(Auth::user()->role->name == 'ADMIN' )
          
            <li class="nav-item  dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masters</a>
                <div class="dropdown-menu">
                <a  class="dropdown-item {{ isActiveRoute('expensecategories') }}" href="{{ route('expensecategories') }}">Expense Types</a>
                <a  class="dropdown-item {{ isActiveRoute('expenses') }}" href="{{ route('expenses') }}">Expenses</a>
              
                <a  class="dropdown-item {{ isActiveRoute('employees') }}" href="{{ route('employees') }}">Employees </a>
                <a  class="dropdown-item {{ isActiveRoute('vendors') }}" href="{{ route('vendors') }}">Vendors </a>
                <a  class="dropdown-item {{ isActiveRoute('products') }}" href="{{ route('products') }}">Products </a>
                <a  class="dropdown-item {{ isActiveRoute('purchases') }}" href="{{ route('purchases') }}">Purchase Entry </a>
                </div>
            </li>
          

          
            {{--<li class="nav-item {{ isActiveRoute('jobcards') }}">
                <a class="nav-link" href="{{ route('jobcards') }}">Jobcards</a>
            </li>--}}
        
        
         <li class="nav-item {{ isActiveRoute('invoices') }}">
            <a class="nav-link" href="{{ route('invoices') }}">Invoices</a>
        </li>
      
            <li class="nav-item  dropdown {{ areActiveRoutes(['campaigns-report','services-report']) }}">
               <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
               <div class="dropdown-menu">
                  <!-- <a class="dropdown-item {{ isActiveRoute('today-report') }}" href="{{ route('today-report') }}">Today Report</a> -->
                   <a class="dropdown-item {{ isActiveRoute('today-report') }}" href="{{ route('today-report') }}">Today Report</a>
                  <a class="dropdown-item {{ isActiveRoute('item-report') }}" href="{{ route('item-report') }}">Item Report</a>
                  <a class="dropdown-item {{ isActiveRoute('expenses-report') }}" href="{{ route('expenses-report') }}">Expense Report</a>
                  <a class="dropdown-item {{ isActiveRoute('stockreport') }}" href="{{ route('stockreport') }}">Stock Report</a>
                  <a class="dropdown-item {{ isActiveRoute('invoices-report') }}" href="{{ route('invoices-report') }}">Invoice Report</a>
                   <a class="dropdown-item {{ isActiveRoute('pay_balance_invoices') }}" href="{{ route('pay_balance_invoices') }}">Payment Balance Invoices</a>
                      <a class="dropdown-item {{ isActiveRoute('purchase-report') }}" href="{{ route('purchase-report') }}">Purchase Report</a> 
                                <a class="dropdown-item {{ isActiveRoute('closing-report') }}" href="{{ route('closing-report') }}">Closing Report</a>
                  
                   
                  <a class="dropdown-item {{ isActiveRoute('purchasecredits') }}" href="{{ route('purchasecredits') }}">Purchase Vendor-Credit Report</a>
                  
              </div>
          </li>
          <li class="nav-item ">
                <a class="nav-link" href="{{ route('closing') }}">Counter Cash</a>
            </li>
             <li class="nav-item ">
                <a class="nav-link" href="{{ route('today-report') }}">Today Report</a>
            </li>
          
          @elseif(Auth::user()->role->name == 'BILLING')
             
            <li class="nav-item  dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masters</a>
                <div class="dropdown-menu">
                <a  class="dropdown-item {{ isActiveRoute('expensecategories') }}" href="{{ route('expensecategories') }}">Expense Category</a>
                <a  class="dropdown-item {{ isActiveRoute('expenses') }}" href="{{ route('expenses') }}">Expenses</a>
          
                
                </div>
            </li>

          
          
        
        
         <li class="nav-item {{ isActiveRoute('invoices') }}">
            <a class="nav-link" href="{{ route('invoices') }}">Invoices</a>
        </li>
      
            <li class="nav-item  dropdown {{ areActiveRoutes(['campaigns-report','services-report']) }}">
               <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
               <div class="dropdown-menu">
                  <!-- <a class="dropdown-item {{ isActiveRoute('today-report') }}" href="{{ route('today-report') }}">Today Report</a> -->
                 
                  <a class="dropdown-item {{ isActiveRoute('stockreport') }}" href="{{ route('stockreport') }}">Stock Report</a>
                  <a class="dropdown-item {{ isActiveRoute('invoices-report') }}" href="{{ route('invoices-report') }}">Invoice Report</a>
                   <a class="dropdown-item {{ isActiveRoute('closing-report') }}" href="{{ route('closing-report') }}">Closing Report</a>
                  <a class="dropdown-item {{ isActiveRoute('expenses-report') }}" href="{{ route('expenses-report') }}">Expense Report</a>
                   <a class="dropdown-item {{ isActiveRoute('pay_balance_invoices') }}" href="{{ route('pay_balance_invoices') }}">Payment Balance Invoices</a>
                   
                 
              </div>
          </li>
          <li class="nav-item ">
                <a class="nav-link" href="{{ route('closing') }}">Counter Cash</a>
            </li>
          
       @endif
   </ul>
</div>
</nav>

<!-- End of navbar -->