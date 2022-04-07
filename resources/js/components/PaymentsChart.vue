<template>
    <div>
        <span>تعداد پرداخت ها در سال 1401</span>
        <canvas ref="payments_count_chart" style="width: 100%" height="400"></canvas>
        <br>
        <span class="mt-3">مجموع پرداخت ها در سال 1401</span>
        <canvas ref="payments_price_chart" style="width: 100%" height="400"></canvas>

    </div>
</template>

<script>
    import Chart from 'chart.js/auto';
    export default {
        name: "PaymentsChart",
        props:['chart_data'],
        mounted() {
            console.log(this.chart_data)
            const payments_count_chart_ctx = this.$refs.payments_count_chart.getContext('2d');
            const payments_price_chart_ctx = this.$refs.payments_price_chart.getContext('2d');

            const paymentCountChart = new Chart(payments_count_chart_ctx, {
                type: 'line',
                data: {
                    labels: this.chart_data.labels,
                    datasets: [
                        {
                        label: 'پرداخت های موفق',
                        data: this.chart_data.paid_count,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                        {
                            label: 'پرداخت های ناموفق',
                            data: this.chart_data.canceled_count,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            const paymentPriceChart = new Chart(payments_price_chart_ctx, {
                type: 'line',
                data: {
                    labels: this.chart_data.labels,
                    datasets: [
                        {
                        label: 'مجموع مبلغ موفق',
                        data: this.chart_data.paid_price,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                        {
                            label: 'مجموع مبلغ ناموفق',
                            data: this.chart_data.canceled_price,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
</script>

<style scoped>

</style>