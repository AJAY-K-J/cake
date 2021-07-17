<template>
    <div>
      <form v-on:submit.prevent="save" class="bookingForm">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Part No<span class="text-danger">*</span></label>
                    <input type="text"  class="form-control" placeholder="Part No" autocomplete="on" v-model="stock.product.name" required maxlength="50">
                    <small v-if="errors.partno_full" class="text-danger">{{ errors.partno_full[0] }}</small>
                </div>
            </div>
        </div>    
        <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                  <label>Quantity<span class="text-danger">*</span></label>
                  <input type="number" class="form-control" placeholder="Quantity" v-model="stock.qty"   autocomplete="on" required>
                  <small v-if="errors.qty" class="text-danger">{{ errors.qty[0] }}</small>
               </div>
            </div>
        </div> 
          
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                <button class="btn btn-primary float-right" type="submit" :disabled="loading">Save</button>
                <button class="btn btn-light float-right mr-2" ref="cancel_btn" data-dismiss="modal" @click="clear_data()" type="button">Close</button>
            </div>
        </div>
    </div>
</form>
</div>
</template>




<script>
import moment from 'moment';
import Autocomplete from 'vuejs-auto-complete'


export default {
   props: ['edit','vendors'],
    created(){
        console.log('edit');
        if(this.edit)
        {
            var vm = this;
            bus.$on('edit-stock',function(id) {

                vm.clear_data();
                axios.get('/find_stock/'+id)
                    .then(response => vm.stock = response.data)
                    .catch(function (error) {
                        console.log(error);
                    });
               
               
            });
        }
    },
    data () {
        return {
            stock: {
                id:'',
                product:'',
                qty: '',
                rate:'',
            },
         
            loading: false,
            errors: {},

        }
    },
    components: {
        Autocomplete,
    },
    methods : {
        clear_data() {
            
            this.stock.id='';
            this.stock.product='';
            this.stock.partno_full='';
            this.stock.rate='';
            this.stock.qty='';
         
        },
        save() {

            this.loading = true;
            axios.post('/edit_stock',this.stock).
            then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        swal("Stock Updated", "", "success");
                    

                    // console.log($(".campaignForm").find('.cancel-btn'));
                    this.$refs.cancel_btn.click();
                    bus.$emit('stock-updated');
                    this.clear_data();
                }
                else if(response.data=="NoSMS"){
                    swal("Low SMS Credit, Please Top Up SMS", "", "error");
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update stock", response.data, "error");
                    
                }
            }).
            catch(error => {
                if(this.edit)
                    swal("Couldn't update stock", "", "error");
                else
                    swal("Couldn't add stock", "", "error");
                this.loading = false;
                if(error.response.data.errors)
                    this.errors  = error.response.data.errors;
                else
                    this.errors = '';
            });
        },
        delete_stock() {
            swal({
                title: "Delete Stock?",
                text: "Are you sure you want to delete this Stock? This cannot be undone!",
                icon: "warning",
                buttons: {
                    cancel: "No",
                    catch: {
                      text: "Delete",
                      value: "willDelete",
                      closeModal: false,
                  },
              },
              dangerMode: true,
          })
            .then((willDelete) => {
                if(willDelete)
                {
                    axios.post('/delete_stock',{
                        id: this.stock.id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        
                        if(response.data == 'Success')
                        {
                            swal("stock deleted", "", "success");
                            bus.$emit('stock-updated');
                            this.$refs.cancel_btn.click();
                        }
                        else
                        {
                            swal("Not deleted", response.data, "error");
                        }

                        
                    }).
                    catch(error => {
                        swal.stopLoading();
                        swal.close();
                        this.errors  = error.response.data.errors;
                        this.loading = false;
                    });
                }
            });
        },
        
    },
     
    mounted() {
            
        },
    watch:{
        
    }
}
</script>

<style lang="css" scoped>
[disabled] {
    background-color: inherit;
    font-weight: bold;
}

.day-checkbox {
    margin: 10px 5px;
}

.day-checkbox,
.day-label,
.day-checkbox input {
    cursor: pointer;
}

.day-checkbox:hover input:not(:disabled) ~ .day-label {
    border-color: #9c27b0;
    color: #9c27b0;
    box-shadow: 1px 1px 8px -1px rgba(0, 0, 0, 0.4);
}

.day-checkbox:hover .day-label.all-days {
    border-color: #4caf50 !important;
    color: #4caf50 !important;
}

.day-label {
    border: 1px solid #ccc;
    /*width: 40px;*/
    padding: 0 10px;
    height: 30px;
    font-size: 12px;
    display: flex;
    justify-content: center;
    border-radius: 20px;
    text-align: center;
    flex-direction: column;
    transition: background 0.25s, border-color 0.25s, color 0.25s, box-shadow 0.25s;
}

.day-checkbox input{
    position: absolute;
    opacity: 0;
}

.day-checkbox input:checked + .day-label{
    background: #9c27b0 !important;
    border-color: #9c27b0 !important;
    color: white !important;
    box-shadow: 1px 1px 8px -1px rgba(0, 0, 0, 0.4);
}

.day-checkbox input:checked + .day-label.all-days{
    background: #4caf50 !important;
    border-color: #4caf50 !important;
    color: white !important;
}

.day-label.fade-label {
    /*background: #14963c69!important;*/
    border-style: dashed;
    border-color: #4caf50 !important;
    color: #4caf50 !important;
}
</style>