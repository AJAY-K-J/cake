@include('layouts.header')

                <section class="content-header">
                    <h1>    
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-3 col-xs-12 col-sm-12">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>TEST </h3>
                                    <p>TEST 1 </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                {{-- <div class="small-box-footer">FIRST</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-sm-12">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>TEST </h3>
                                    <p>TEST 1 </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                {{-- <div class="small-box-footer">SECOND</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-sm-12">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>TEST </h3>
                                    <p>TEST 1 </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                {{-- <div class="small-box-footer">THIRD</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-sm-12">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>TEST </h3>
                                    <p>TEST 1 </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                {{-- <div class="small-box-footer">FORTH</div> --}}
                            </div>
                        </div>                    
                    </div>
                    {{-- NOTIFICATIONS --}}
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Important Notifications</h3>
                        </div>
                        <div class="box-body no-padding">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Notification</th>
                                    <th>Notification Published Date</th>
                                </tr>
                                {{-- @php
                                    $i=1;
                                @endphp
                                @foreach ($items as $key=> $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->name }} - Result Published</td>
                                        <td>{{ $item->updated_at }}</td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach --}}
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                      <!-- /.box -->
                </div>
            </section>
        </div>
@include('layouts.footer')
        