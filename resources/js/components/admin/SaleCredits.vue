<template>

  <div class="row">
    <div class="nav-tabs-navigation mb-8">
      <div class="nav-tabs-wrapper">
        <ul class="nav nav-pills nav-pills-primary" data-tabs="pills">
          
          <li>
            <form v-on:submit.prevent="get_paybalancereceipts(search)" >  
              <div class="input-group">
                <input type="search" placeholder="Receipt NO/Mobile No: " v-model="search" id="search" class="form-control" style="width:300px;">
                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" style="background-color:#454334">Search</button>
                </div>
              </div>
            </form>
          </li>
          <li>
            <button class="btn btn-primary btn-sm" style="background-color:#ff4433" @click="search='';get_paybalancereceipts();">Reset</button>
          </li>
          <li>
           <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Balance: {{ total_balance }}</b></h4>
          </li>
  
        </ul>
      </div>
    </div>          
     <div class="col-12">
      <div class="table-responsive">
        <table class="custom-table table table-hover">
          <thead>
            <tr>
              <th style="width: 5%;">S/N</th>
              <th style="width: 60%;">Receipt Details</th>
              <th style="width: 35%;">Options</th>

            </tr>
          </thead>
          <tbody>
            <tr v-for="(receipt,index) in receipts" >


              <td>{{ index+1 }}</td>
              <td class="newspaper"> 

                <table class='table borderless'>
                  <tbody>
                    <tr>
                      <td>
                        Date: 
                      </td>
                      <td align="left">
                        <b>{{ getformatteddate(receipt.created_at) }}</b>
                      </td>
                    </tr>  
                    <tr>
                      <td>
                        Receipt No:
                      </td>
                      <td align="left">
                        <b>{{ receipt.receipt_no }}</b>
                      </td>
                    </tr>  
                    <tr>
                      <td>
                        Customer Name:
                      </td>
                      <td align="left">
                        <b>{{ receipt.customer_name }}</b>
                      </td>
                    </tr>  
                    <tr>
                      <td>
                        Mobile: 
                      </td>
                      <td align="left">
                        <b>{{ receipt.mobile }}</b>
                      </td>
                    </tr> 
                    <tr>
                      <td>
                        Remarks:
                      </td>
                      <td align="left">
                        <b>{{ receipt.remarks }}</b>
                      </td>
                    </tr> 
                    <tr>
                      <td>
                        Balance Amount:
                      </td>
                      <td align="left">
                        <b>Rs.{{ receipt.total_net_amount-receipt.received_amount }}</b>
                      </td>
                    </tr>  
                  </tbody>
                </table>


                <td >
                  
                  <a class="btn btn-success btn-sm m-0" :href="'/payments/'+receipt.id"  style="background:#3e2723">
                    <i class="fas fa-receipt"  aria-hidden="true" ></i>
                  </a>
                </td>

              </tr>
              <tr v-if="receipts.length==0">
                <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Balance Paynent'}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      
    </div>
  </div>
</template>

<script>
import moment from 'moment';

export default {
  /*mixins:[mixins],*/  /*props:['PROPERTY'],*/
  props: ['total_balance'],
  created(){
  this.get_paybalancereceipts();
            var vm =this;
            
  },
  data () {
    return {
      
      receipts: {},
      loading : false,
      uploading : false,
      errors  : {},
      file: '',
      search:'',
      id:'',
      amount:'',
      total_balance:'',
      image_preview: '',
    }
  },
  methods : {
    getformatteddate(date) {
      return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
    },
    



    get_paybalancereceipts() {
      this.loading = true;
      this.receipts = [];
      if(this.company_id)
      {
        var url = '/get_sale_credits?company_id='+this.company_id;  

      }
      else
      {
        var url = '/get_sale_credits?search='+this.search;
        
      }
      axios.get(url,{
        params : {
          type: this.type
        } 
      }).
      then(response => {
        this.receipts = response.data;
        this.loading = false;

        this.$nextTick(() => {
          $(".table-responsive").floatingScroll();
        })
      }).
      catch(err => {
        this.loading = false;
      });
    },
    get_total_balance() {     
        axios.get('/get_total_balance_receipt').then(response => {
        this.total_balance = response.data;
        console.log(this.total_balance);
        });
      },

    convert_date(date) {
      return moment(date).format('DD-MM-YYYY');
    },
    
    
    



  },
  mounted() {


  },

}
</script>

<style lang="css" scoped>

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

.preview {
  display: block;
  margin: 20px auto 0 auto;
  width: 300px;
  height: 100px;
  object-fit: contain;
  object-position: center;
}

#imagePreviewModal {
  background: #000000aa;
  height: 100vh;
  width: 100vw;
  left: 0;
  top: 0;
  position: absolute;
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 1050;
}

#imagePreviewModal .image-modal-body {
  max-height: 500px;
  max-width: 500px;
}

#imagePreviewModal .image-modal-body img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center;
}
.newspaper {


  -webkit-column-gap: 40px; /* Chrome, Safari, Opera */
  -moz-column-gap: 40px; /* Firefox */
  column-gap: 40px;
}

#imagePreviewModal.show {
  display: flex!important;
}

.close-image-modal {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  box-shadow: none;
}
.borderless td, .borderless th {
  border: none;
  padding: 0px;
  margin: 0px;
  text-align: left;
  width:50%;
}


</style>