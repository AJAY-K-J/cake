<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-fluid">
   
  <h3>Dashboard</h3>
   
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

</script>
<?php $__env->stopPush(); ?>

<style>
/*header { position: fixed; top: -30px; left: 0px; right: 0px; height: 20px; }*/

html body {
    font-family: arial, sans-serif ;
    font-size: 12px;
    color: #000000;
    margin: 0px;
    /* background: #fff; */
}
table {
    background-color: transparent;
}
table {
    border-spacing: 0;
    border-collapse: collapse;
}
.table {
    width: 100%;
    max-width: 100%;
    padding-top: 0;
    padding-bottom: 0;
  
}
.table-bordered {
    border: 1px solid #000;
}
.border {
    border: 1px solid #000;
 
}
.m-8{
    margin-left: 8px;
    margin-right: 8px;
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #000;
}
td,th {
    padding-left:3px;
    padding-right:3px;
    padding-top: 1px;
    padding-bottom: 1px;
}
.text-center{
    text-align: center;
}
.text-right{
    text-align: right;
}
.row:after {
    content: "";
    display: table;
    clear: both;
}
.col-2{
    float: left;
    width:16.66666667%;
}
.col-3{
    float: left;
    width:25%;
}
.col-4{
    float: left;
    width:33.33333333%;
}
.col-6{
    float: left;
    width:50%;
}
.col-8{
    float: left;
    width:66.66666667%;
}
.col-10{
    float: left;
    width:83.33333333%;
}
.mb-10{
    margin-bottom: 10px;
}
.mb-6{
    margin-bottom: 6px;
}
.mt-10{
    margin-top: 10px;
}
.dotted {
    border: none;
    border-bottom: 1px dotted #040404;
    color: #fff;
    background-color: #fff;
    margin: 0 13px 0 11px;
}
.clearfix{

    clear: both;
}
.ptb-0{
    padding-top: 0;
    padding-bottom: 0;
}
.text-right{
    text-align: right;
}
.logo {
  
    max-width: 150px;
    max-height: 30px;
    
       top: 0px;
       right: 0px;
    object-position: top right;
    
}
.column {
  float: left;
  width: 33.33%;
}


.column {
  float: left;
  width: 13%;

  border: 1px solid green;
  padding: 10px;
  margin: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;

}

.box {
  width: 300px;
  border: 1px solid green;
  padding: 20px;
  margin: 20px;
}
</style>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/shopadmin/dashboard.blade.php ENDPATH**/ ?>