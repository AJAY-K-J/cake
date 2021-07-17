<template>
    <div class="row">
        <div class="nav-tabs-navigation mb-4">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-pills nav-pills-primary" data-tabs="pills">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" @click="type='active'" :class="{'active' : type=='active'}">Pending Completion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" @click="type='expired'" :class="{'active' : type=='expired'}">Pending Delivery</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="custom-table table table-hover">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Booking Date</th>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Register No</th>
                            <th>Service</th>
                            <th>Remarks</th>
                            <th>Delete</th>
                            <th v-if="type == 'active'">Mark Completed</th>
                            <th v-else>Mark Delivered</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(booking,index) in bookings">
                            <td>{{ index+1 }}</td>
                            <td>{{ getformatteddate(booking.created_at) }}</td>
                            <td>{{ booking.name }}</td>
                            <td>{{ booking.model }}</td>
                            <td>{{ booking.reg_no }}</td>
                            <td>{{ booking.service.name }}</td>
                            <td>{{ booking.remarks?booking.remarks:'NA' }}</td>
                            <td v-if="booking.reg_status==0"><button class="btn btn-danger btn-sm m-0" @click="delete_booking(booking.id)">Delete</button></td>
                            <td v-else>NA</td>

                            <td v-if="type == 'active'"><button class="btn btn-success btn-sm m-0" @click="mark_completed(booking.id)">
                            Mark Completed</button></td>
                            
                            <td v-else><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#deliveryModal" @click="show_delivery_modal(booking.id)">
                            Mark Delivered</button>
                            <button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#creditModal" @click="show_credit_modal(booking.id)">
                                                        Credit Delivery</button>

                        </td>

                          
                            
                        </tr>
                        <tr v-if="bookings.length==0">
                            <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Bookings'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="deliveryModal" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">Are you sure, mark this Delivered</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="amountForm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Enter Amount<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Delivery Amount" v-model="amount" required maxlength="10">
                                        <small v-if="errors.amount" class="text-danger">{{ errors.amount[0] }}</small>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary float-right" type="submit" :disabled="loading" @click="mark_delivered(id,amount)">Save</button>
                                        <br>
                                        <button class="btn btn-light float-right mr-2 cancel-btn" data-dismiss="modal" @click="clear_data()" type="reset">Close</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="creditModal" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">Are you sure, mark this Delivered</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="amountForm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Enter Credit Amount<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Credit Amount" v-model="amount" required maxlength="10">
                                        <small v-if="errors.amount" class="text-danger">{{ errors.amount[0] }}</small>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary float-right" type="submit" :disabled="loading" @click="mark_creditdelivered(id,amount)">Save</button>
                                        <button class="btn btn-light float-right mr-2 cancel-btn" data-dismiss="modal" @click="clear_data()" type="reset">Close</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import moment from 'moment';

export default {
    /*mixins:[mixins],*/  /*props:['PROPERTY'],*/
    props: ['services'],
    watch: {
        type : function() {
            this.get_bookings();
        }
    },
    created(){
        this.get_bookings();
        if(this.type == 'expired')
            this.expired = true;
        var vm =this;
        bus.$on('booking-updated', function(){
            vm.get_bookings();
        });         
    },
    data () {
        return {
            type: 'active',
            bookings: {},
            loading : false,
            uploading : false,
            errors  : {},
            file: '',
            expired: false,
            file_import: {
                id: '',
                name: '',
                code: '',
                file: '',
                type: '',
            },
            duplicates : '',
            id:'',
            amount:'',
        }
    },
    methods : {
        getformatteddate(date) {
                        return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    },
        get_bookings() {
            this.loading = true;
            this.bookings = [];
            axios.get('/get_bookings',{
                params : {
                    type: this.type
                }
            }).
            then(response => {
                this.bookings = response.data;
                this.loading = false;

                this.$nextTick(() => {
                    $(".table-responsive").floatingScroll();
                })
            }).
            catch(err => {
                this.loading = false;
            });
        },
        show_delivery_modal(id)
        {
            this.id=id;
            this.amount='';

        },
        show_credit_modal(id)
        {
            this.id=id;
            this.amount='';

        },
        convert_date(date) {
            return moment(date).format('DD-MM-YYYY');
        },
        clear_data() {

            this.amount = '';

        },
        mark_completed(id) {
            swal({
                title: "Mark Completion?",
                text: "Are you sure you want to mark this Completed",
                icon: "warning",
                buttons: {
                    cancel: "No",
                    catch: {
                      text: "Yes",
                      value: "willDelete",
                      closeModal: false,
                  },
              },
              dangerMode: true,
          })
            .then((willDelete) => {
                if(willDelete)
                {
                    axios.post('/mark_completed',{
                        id: id  
                    })
                    .then(response => {
                        if (response.data.status == 1) 

                            swal("Mark Completed Successfully", "", "success");
                        else
                            swal(response.data.response,"", "error");

                        this.get_bookings();
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
        delete_booking(id) {

            swal({
                title: "Delete Booking?",
                text: "Are you sure you want to delete this Booking? This cannot be undone!",
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
                    axios.post('/delete_booking',{
                        id: id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        swal("Booking deleted", "", "success");
                        this.get_bookings();
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
        mark_delivered(id,amount) {
            this.loading = true;
            axios.post('/mark_delivered',{
                id: id,
                amount:amount 
            })
            .then(response => {
                if (response.data.status == 1) 
                    swal("Vehicle Delivered Successfully", "", "success");
                else
                    swal(response.data.response,"", "error");
                this.get_bookings();
                $("#deliveryModal").modal('hide');

            }).
            catch(error => {

                this.errors  = error.response.data.errors;
                this.loading = false;
            });
        },
        mark_creditdelivered(id,amount) {
            this.loading = true;
            axios.post('/mark_creditdelivered',{
                id: id,
                amount:amount 
            })
            .then(response => {
                if (response.data.status == 1) 
                    swal("Vehicle Delivered Successfully", "", "success");
                else
                    swal(response.data.response,"", "error");
                this.get_bookings();
                $("#creditModal").modal('hide');

            }).
            catch(error => {

                this.errors  = error.response.data.errors;
                this.loading = false;
            });
        }

    },
    mounted() {
        $(".table-responsive").floatingScroll();
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
</style>