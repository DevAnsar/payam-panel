<template>
    <div>
        <div class="form-group row">
            <label for="example-search-input" class="col-md-2 col-form-label">
                تعداد:
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-10">
                <input class="form-control" style="direction: ltr" type="number" name="count"
                       v-model="count" />
            </div>
        </div>

        <div class="form-group row">
            <label for="example-search-input" class="col-12 col-form-label">
                قیمت:
                {{new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(price)}}
                ریال
            </label>

        </div>
    </div>
</template>

<script>
    export default {
        name: "PackageSmsCount",
        props:['default_count','sms_tariff'],
        data(){
            return{
                count : 0,
                price : 0
            }
        },
        methods:{
            setPrice(count){
                this.price = count * this.sms_tariff;
            }
        },
        mounted() {
            if (this.default_count){
                this.count = this.default_count;
            }
            this.setPrice(this.count);
        },
        updated() {
            this.setPrice(this.count);
        }
    }
</script>

<style scoped>

</style>
