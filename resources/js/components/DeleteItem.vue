<template>
    <button type="button"
            class="btn btn-outline-secondary btn-sm"
            data-toggle="tooltip"
            data-placement="top"
            title="Delete"
            v-on:click="deleteItem"
    >

            <span v-if="loading" class="">در حال حذف</span>
            <i v-else class="mdi mdi-trash-can"></i>

    </button>
</template>

<script>
    export default {
        name: "DeleteItem",
        props:['url'],
        data(){
            return{
                loading : false
            }
        },
        methods:{
            async deleteItem(){

                /////
                const res = await Swal.fire({title:"هشدار",
                    text:"آیا از خذف این آیتم مطمعن هستید؟",
                    icon:"warning",
                    showCancelButton:!0,
                    confirmButtonText:"بله، حذف کن!",
                    cancelButtonText:"نه، بیخیال",
                    confirmButtonClass:"btn btn-success mt-2",
                    cancelButtonClass:"btn btn-danger ml-2 mt-2",
                    buttonsStyling:!1}
                )
                if(res.value){
                    const res = await window.axios.delete(`${this.url}`);
                    console.log(res)
                    if(res.status === 200){
                        Swal.fire({title:"حذف شد!",text:"آیتم انتخابی با موفقیت حذف شد",icon:"success"});
                        setTimeout(()=>window.location.reload(),1000)
                    }else {
                        Swal.fire({title:"خطا!",text:res.message,icon:"warning"});
                    }
                            // .then(res=>{
                            //     Swal.fire({title:"حذف شد!",text:"آیتم انتخابی با موفقیت حذف شد",icon:"success"});
                            //     setTimeout(()=>window.location.reload(),1000)
                            //
                            // }).catch(err=>{
                            //     console.log(err)
                            // }).finally(()=>this.loading = false)
                }



                // Swal.fire({title:"هشدار",
                //     text:"آیا از خذف این آیتم مطمعن هستید؟",
                //     icon:"warning",
                //     showCancelButton:!0,
                //     confirmButtonText:"بله، حذف کن!",
                //     cancelButtonText:"نه، بیخیال",
                //     confirmButtonClass:"btn btn-success mt-2",
                //     cancelButtonClass:"btn btn-danger ml-2 mt-2",
                //     buttonsStyling:!1}
                // ).then(function(t){
                //     console.log(t)
                //     if(t.value){
                //
                //         window.axios.delete(`${link}`).then(res=>{
                //             Swal.fire({title:"حذف شد!",text:"آیتم انتخابی با موفقیت حذف شد",icon:"success"});
                //             setTimeout(()=>window.location.reload(),1000)
                //
                //         }).catch(err=>{
                //             console.log(err)
                //         }).finally(()=>this.loading = false)
                //     }
                // })

            }
        }
    }
</script>

<style scoped>

</style>
