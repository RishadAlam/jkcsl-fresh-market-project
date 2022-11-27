$(document).ready(function(){
    // $(".select").select2();

    /**
     * SummerNote
    */
    $('textarea').summernote({
        height: 150, 
    });

    /**
     * Date Picker
     */
    duDatepicker('#date');
    duDatepicker('#daterange',{
        range:true
    });
    
    // tail.select("select", {
    //     search: true
    // });
})