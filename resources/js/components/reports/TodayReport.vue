<template>
    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4" style="margin-top:20px">
                        <h4><b>Today's Summary</b></h4>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" placeholder="Date" autocomplete="off" required="required" v-model="shiner.date" class="form-control" :max="shiner.today">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <button @click="get_todays_details" class="btn btn-block btn-success btn-sm m-0 mr-md-2">Filter</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <button @click="clear_filter"  class="btn btn-block btn-info btn-sm m-0">Clear Filters</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <a  :href="`/get_today_deatils/report?date=${shiner.date}&export=true`" class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
                    </div>
                </div>
            </div>
        </div>  
       <div class="col-md-7" style="float:left;">
       <div class="tag">
    <h4>INVOICE</h4>
    <div class="card ">
            <div class="card-body">
              <table border=0 width=400px style="font-size:20px;">
               <tr>
                 <td>Created</td>
                 <td><b>: {{ jobcard.sales}}</b></td>
               </tr>
              
               <tr>
                 <td>Invoice Total Discount</td>
                 <td><b>: {{ jobcard.sale_total_discount }}</b></td>
               </tr>
               <tr>
                 <td>Invoice Total Amount</td>
                 <td><b>: {{ jobcard.sale_total_amount }}</b></td>
               </tr>
            </table>
            </div>
    </div>
    <!--  <h4>INCOME</h4>
    <div class="card ">
            <div class="card-body">
              <table border=0 width=400px style="font-size:20px;">
               <tr>
                 <td>Created</td>
                 <td><b>: {{ jobcard.incomes }}</b></td>
               </tr>
                
               <tr v-for="cat in jobcard.inc_cats">
                 <td>{{ cat.name}}</td>
                 <td><b>: {{ cat.amount}}</b></td>
               </tr>
               <tr>
                 <td>Total Income</td>
                 <td><b>: {{ jobcard.inc_total_amount }}</b></td>
               </tr>
            </table>
            </div>
    </div> -->
    <h4>EXPENSE</h4>
    <div class="card ">
            <div class="card-body">
              <table border=0 width=400px style="font-size:20px;">
               <tr>
                 <td>Created</td>
                 <td><b>: {{ jobcard.expenses }}</b></td>
               </tr>
                
               <tr v-for="cat in jobcard.cats">
                 <td>{{ cat.name}}</td>
                 <td><b>: {{ cat.amount}}</b></td>
               </tr>
               <tr>
                 <td>Total Expense</td>
                 <td><b>: {{ jobcard.exp_total_amount }}</b></td>
               </tr>
            </table>
            </div>
    </div>
    <h4>ITEMS</h4>
    <div class="card">
            <div class="card-body">
              <table border=0 width=400px style="font-size:20px;">

                <tr>
                  <td><b>Part No</b></td>
                  <td><b>Qty</b></td>
                  <td><b>Amount</b></td>
                </tr>
               <tr v-for="part in jobcard.parts">
                 <td>{{ part.name}}</td>
                 <td>{{ part.qty}}</td>
                 <td>{{ part.amount}}</td>
               </tr>
               <tfoot>
                 <tr>
                  <td>Total</td>
                  <td><b>{{ jobcard.item_total_qty}}</b></td>
                  <td><b>{{ jobcard.item_total_amount}}</b></td>
                </tr>
               </tfoot>
            </table>
            </div>
          </div>  
    </div>
    </div>
      <div v-if="jobcard.opening_balance=='0.00'" class="col-md-5 const" style="float:left;">
         <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fa fa-warning"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><b>Opening Blanace Not Found!!!</b></span>
                <span class="info-box-number">always Set Openings..</span>
              </div>
              
            </div>

      </div>
     <div v-else class="col-md-5 const" style="float:left;">
            
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fa fa-briefcase"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><b>Today Opening</b></span>
                <span class="info-box-number"><td v-for="type in jobcard.openings">{{ type.type }} :<b>{{ type.amount }}</b></td></span>
              </div>
              
            </div>  
           
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><b>Today Collection</b></span>
                <span class="info-box-number"><td v-for="type in jobcard.collections">{{ type.type }} :<b>{{ type.amount }}</b></td></span>
              </div>
              
            </div>
            
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fab fa-gg"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><b>Today Expense</b></span>
                <span class="info-box-number"><td v-for="type in jobcard.expense">{{ type.type }} :<b>{{ type.amount }}</b></td></span>
              </div>
              
            </div>
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fa fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><b>Balance Amount</b></span>
                <span class="info-box-number"><td v-for="type in jobcard.balances">{{ type.type }} :<b>{{ type.amount }}</b></td></span>
              </div>
              
            </div>
            
          </div>
     <div class="clearfix">
     </div>  
    </div>

</template>

<script>
import moment from 'moment';
import mixins from '../../mixins/jarvis';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
    mixins:[mixins],  props:[],
    created(){
       this.get_todays_details();
            var vm =this;

    },
    mounted() {
        
    },
    data () {
        return {
          jobcard:[],
          details:[],
           shiner: {
                date:'',
                today:new Date().toISOString().slice(0,10),
            },
          loading: false,
        }
    },
    methods : {
        get_todays_details(){
          this.loading = true;
          axios.get('/get_today_deatils/report',{
            params: {
                  date:this.shiner.date,
             }
          }).
          then(response => {
           if(response.data == 'error'){
              swal("Please Add Opening Balance!!", "", "error");
              this.shiner.date='';
              window.location.href = '/closing'
            }
            else{
            this.jobcard = response.data;
            this.loading = false;
            }
          }).
          catch(error => {
            this.loading = false;
          });
        },
        clear_filter(){
            this.shiner.date='';
            this.get_todays_details();
        },
       

    },
}
</script>

<style lang="css">
.nav-item:hover {
  cursor: pointer;
}

.nav-pills .nav-item .nav-link {
  border-radius: 0.2rem;
  padding: 4px 10px;
}
.nav-pills .nav-item .nav-link.active {
  box-shadow: 1px 4px 16px 0 rgba(0,0,0,.2), 0px 4px 4px -11px rgba(156,39,176,.6);
}
.const{
  //background:#78909c;
  padding:10px;
  margin-top:50px;
  border-radius:10px;
}
.const table tr td{
  color:#fff;
}
.const table tr{
  background:#f63;
  margin-bottom:10px;
  padding:5px;
  border-radius:8px;
  display:block;
}
.tag{
  padding:10px;
  border-radius:10px;

}
.card{
  margin-top: 10px !important;
}
.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: .25rem;
    background: #fff;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: .5rem;
    position: relative;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}
.info-box .info-box-icon {
    border-radius: .25rem;
    -ms-flex-align: center;
    align-items: center;
    display: -ms-flexbox;
    display: flex;
    font-size: 1.875rem;
    -ms-flex-pack: center;
    justify-content: center;
    text-align: center;
    width: 70px;
}
.info-box .info-box-text, .info-box .progress-description {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.info-box .info-box-content {
    -ms-flex: 1;
    flex: 1;
    padding: 5px 10px;
}
.info-box-number td{
  Padding-right:10px;
}
</style>