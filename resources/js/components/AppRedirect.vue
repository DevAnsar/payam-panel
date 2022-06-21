<template>
    <div class="card p-3">
        <div class="alert" :class="{alert_type}" v-text="message" />
        <button v-on:click="handleRedirect" class="btn btn-warning text-white mdi-cursor-pointer" type="submit">
            بازگشت به برنامه
        </button>
        <div class=" pt-3" style="text-align: center">
            انتقال خودکار بعد از
            {{second}}
            ثانیه
        </div>
    </div>
</template>

<script>
    export default {
        name: "AppRedirect",
        props: ['message','type','link'],
        data() {
            return {
                message: this.message,
                type: this.type,
                alert_type: "alert-"+this.type,
                link: this.link,
                second: 10,
            }
        },
        mounted(){
            this.redirect();
        },
        methods:{
            redirect(){
                let interval=setInterval(()=>{
                    console.log('go');
                    this.second=this.second-1;
                    if (this.second===0){
                        console.log('redirect');
                        clearInterval(interval);
                        window.location = this.link;
                    }
                },1000);
            },
            handleRedirect(){
                window.location = this.link;
            }
        }
    }
</script>

<style scoped>

</style>
