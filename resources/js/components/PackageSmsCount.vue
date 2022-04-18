<template>
    <div>
        <div class="form-group row">
            <label for="price-input" class="col-md-2 col-form-label">
                قیمت پکیج:
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-10">
                <input @change="priceHandler"
                        class="form-control" style="direction: ltr" id="price-input" type="number"
                       name="price"
                       v-model="price" />
                ریال
            </div>
        </div>

        <div class="form-group row">
            <label for="count-input" class="col-md-2 col-form-label">
                تعداد:
            </label>
            <div class="col-md-10">
                <input class="form-control" style="direction: ltr" type="number" id="count-input" name="count"
                      v-model="main_count"  />
            </div>
        </div>

        <div class="form-group row">
            <label for="count-input" class="col-md-2 col-form-label">
                تعرفه:
            </label>
            <div class="col-md-10">
                <span class="badge badge-soft-info">
                    {{new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(tariff)}}
                    ریال
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PackageSmsCount",
        props:['default_price','default_count','this_package_tariff','sms_tariff'],
        data(){
            return{
                count : 0,
                price : 0,
                main_count :0,
                tariff : 0
            }
        },
        methods:{
            setCount(price){
                this.count = price / this.sms_tariff;
                this.setTariff();
            },
            setTariff(){
                this.tariff = this.price / this.main_count;
            },
            priceHandler(){
                console.log('priceHandler');
                this.main_count = this.count
            }
        },
        mounted() {
            if (this.default_price){
                this.price = this.default_price;
            }
            if (this.default_count){
                this.main_count = this.default_count;
            }

            if (this.this_package_tariff){
                this.tariff = this.this_package_tariff;
            }else {
                this.setTariff(this.price);
            }

        },
        updated() {
            this.setCount(this.price);
        }
    }
</script>

<style scoped>

</style>
