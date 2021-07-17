  <template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        
                        <th>Vendor</th>
                        <th>Credit Amount</th>
                        <th>Details</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(vendor,index) in vendors">
                        
    
                       
                        <td>{{ vendor.vendor.name}}</td>
                       <td>{{ vendor.balance_amount}}</td>
                       <td>
                           <a class="btn btn-info btn-sm m-0" :href="'/purchase_details/'+vendor.vendor_id">Purchase Details</a>
                       </td>
                     
                    </tr>
                    <tr v-if="vendors.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Credits'}}</td>
                    </tr>
                </tbody>
            </table>

            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props:[],
        name: "vendors",
        created(){
            this.get_purchasecredits();
            
        },
        data () {
            return {
                vendors: {},   
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_purchasecredits() {
                this.loading = true;
                axios.get('get_purchasecredits').
                then(response => {
                    this.vendors = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },
                  
            clear_data() {
             

                 // this.shiner.credit_amount = '';
             },
        

        },
    }
</script>

<style lang="css" scoped>

</style>