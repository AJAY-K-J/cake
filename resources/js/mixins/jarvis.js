export default {
    data(){
        return {
            croppa: {},
            sliderVal: 0,
            sliderMin: 0,
            sliderMax: 0,
        }
    },
    methods : {  
        swal(title,text,icon,danger,closeOn,reload){
            swal({
                title: title,
                text:text,
                icon: icon, //success,error,warning,info
                dangerMode: danger,
                closeOnEsc : closeOn,
                closeOnClickOutside : closeOn,
            }).then((next) => {
                if (next) {
                    if(reload == true){
                        location.reload(true);
                    } else if(reload == false)
                    {}else{
                        window.location.href=reload;
                    }
                }
            });
        },
        // swal({
        //   title: "Are you sure?",
        //   text: "Once deleted, you will not be able to recover this !",
        //   icon: "warning",
        //   buttons: true,
        //   dangerMode: true,
        // })
        // .then((willDelete) => {
        //     if (willDelete) {
        //         axios.METHODDDD('/URLLLL/'+IDDDD).
        //         then(response => {
        //             this.$delete(this.ARRAYYYY,index);
        //             this.swal(response.data,'','success',false,true,false);
        //         });
        //     }
        // });
        to_array(object_observer){
            const myArrStr = JSON.stringify(object_observer);
            return JSON.parse(myArrStr);
        },
        // delete intead of splice(BETTER AND VERY EASY (ALSO WORKS IN BOTH ARRAYS AND OBJECTS))
        // remove(index) {
        //     this.$delete(this.todos, index)
        // },
        // index_finder(box_type_id){ //GET THE INDEX OF ONE PARTICULAR ROW FROM ARRAY
        //     var indddex = this.selected_boxes.findIndex(x => x.box_type_id == box_type_id);  
        //     this.$delete(this.selected_boxes, indddex);          
        // },
        // FILTER_ARRAY(VALUE){
        //     var arrR = ARRAY.filter(function(ARR){
        //        return (ARR.KEY == VALUE)
        //     });
        //     if(arrR.length > 0) {
        //         return arrR[0].COLUMN;
        //     } else {
        //         return '-';
        //     }
        // },
        onNewImage() {
            this.sliderVal = this.croppa.scaleRatio;
            this.sliderMin = this.croppa.scaleRatio / 1;
            this.sliderMax = this.croppa.scaleRatio * 3;
        },
        onSliderChange(evt) {
            var increment = evt.target.value;
            this.croppa.scaleRatio = +increment;
        },
        onZoom() {
            if (this.sliderMax && this.croppa.scaleRatio >= this.sliderMax) {
                this.croppa.scaleRatio = this.sliderMax
            } else if (this.sliderMin && this.croppa.scaleRatio <= this.sliderMin) {
                this.croppa.scaleRatio = this.sliderMin
            }
            this.sliderVal = this.croppa.scaleRatio;
        },
        // file_upload(e){
        //     let image = e.target.files[0];
        //     var name  = image.name;
        //     var ext   = name.split('.').pop();
        //     if(ext != 'jpg' && ext != 'jpeg' && ext != 'png' && ext != 'pdf')
        //     {
        //         swal({
        //             title: 'File format not supported',
        //             icon: 'warning',
        //             dangerMode: true,
        //         }).then((willDelete) => {
        //             if (willDelete) {}
        //         });
        //         $("#file").val('');
        //         this.shiner.file = '';
        //     }
        //     else
        //     {
        //         let reader = new FileReader();
        //         reader.readAsDataURL(image);
        //         reader.onload = e => {
        //             this.shiner.file_4 = e.target.result;
        //         }
        //     }
        // },        
    }

    /*=====================================================TIPS=====================================================*/
    /*===============FIRE IT===============*/
    // axios.post('/fire_it',{
    //     table : 'TABLE',
    //     where : [
    //          ['COLUMN','VALUE'],
    //          ['COLUMN','!=','VALUE'],
    //      ],
    //     method  : 'METHOD',
    //     columns : 'COLUMN1,COLUMN2',
    //     orderBy : 'COLUMN',
    // }).then(response => {
    //     if(response.data != 'NO DATAS FOUND')
    //     {
    //         console.log(response.data);
    //     }
    //     else
    //     {
    //         swal(""+response.data);
    //     }
    // });
}