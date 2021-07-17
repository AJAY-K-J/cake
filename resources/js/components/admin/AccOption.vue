<template>
<div>
    <div class="card">  
      <div class="card-body">
        <h4 class="card-title">Today Acoount Details</h4>
        <div v-if="flag=='OFF'">
        <h5 class="row" >
         <form v-on:submit.prevent="add_opening">
          <div class="col-md-4 mb-6" v-for="type in payment_types">
            <b>{{ type.name }} :</b> <input type="number"  v-model="opening_balance[type.name]" placeholder="000.00" >
          </div>
          <div class="row">    
            <div class="col-md-4">
              <button class="btn btn-primary btn-md" style="float-right;" type="submit">Save</button>
            </div>
          </div>
         </form>  
         </h5>
        </div> 
        <div v-if="flag=='ON'">
        <h4>Today Opening Balance</h4>
        <h5 class="row">
          <div class="col-md-2 mb-6" v-for="open in opening">
            <b>{{ open.type }} :</b>{{ open.amount }}
          </div>
        </h5>
        <h4>Today Collection</h4>
        <h5 class="row" > 
          <div class="col-md-2 mb-2" v-for="type in collections">
            <b>{{ type.type }} :</b>{{ type.amount }} 
          </div>
        </h5>  
        <h4>Today Expense</h4>
        <h5 class="row" >   
          <div class="col-md-2 mb-2" v-for="type in expenses">
            <b>{{ type.type }} :</b>{{ type.amount }} 
          </div>
        </h5>
        <h5 class="row" >
          <button class="btn btn-success float-left" @click="close_acc();">CLOSE ACCOUNT</button>
        </h5>  
        </div>
        <div v-if="flag=='CLOSE'">
        <h5 class="row">
           <h4 style="color:#ff0000"><b>ACCOUNT CLOSED!</b></h4>
        </h5>
        </div>
        <div v-if="flag=='SHOW'">  
        <h5 class="row" >
          <div class="col-md-3 mb-6">
            <b>Today Total Counter Opening :</b> {{ this.todays.opening_balance }}
          </div>
           <div class="col-md-3 mb-6">
            <b>Today Total Collection :</b> {{ this.todays.total_collection }}
          </div>
          <div class="col-md-3 mb-2">
            <b>Today Total Expense :</b> {{ this.todays.total_expense }}
          </div> 
          <div class="col-md-3 mb-2">
            <b>Today Closing Balance :</b> {{ this.todays.closing_balance }}
          </div>
        </h5>
        </div>

      </div>
    </div>
</div>    
</template>

<script>
import moment from 'moment';



export default {
    props: ['payment_types','collections','expenses'],
    created() {
     this.get_openingbalance();
            var vm =this;
    },
    data(){
     return{
       opening_balance:{},
       opening:{},
       todays:{},
       flag:'',
       loading: false
      }
     }, 
    methods: {
      get_openingbalance(){
        this.loading = true;
        axios.get('get_opening').then(response=>{
           this.opening = response.data;    
            
            this.flag = 'ON'
            if(response.data == 'BLANK')
            {
               this.flag = 'OFF'
            }
            if(response.data == 'CLOSE')
            {
               this.flag = 'CLOSE' 
            }
            
        });

      },
      add_opening(){
       axios.post('add_opening',this.opening_balance).then(response=>{
       swal("Opening Counter amount Added", "", "success");
       this.get_openingbalance();
      
       });

      },
      close_acc()
      {
        axios.post('close_acc',{
             opening:this.opening, 
             
        }).then(response =>{ 
            console.log(response.data);
            this.flag = 'SHOW';
            this.todays = response.data;
        });
      },      
    },
  }
</script>
<style lang="css" scoped>
.center{ 
  text-align-last: center; 
  border: 2px solid black; 
} 

</style>



