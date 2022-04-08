<template>
    <div>
        <span>
            {{this.title}}
        </span>
        <canvas ref="chart" style="width: 100%" height="400"></canvas>
    </div>
</template>

<script>
    export default {
        name: "Chart",
        props:['title','x_axis','y_axis','type'],
        mounted() {
            const yAxis=this.y_axis.map(y=>{
                return {
                    label: y.label,
                    data: y.data,
                    backgroundColor: y.backgroundColor ?? 'rgba(54, 162, 235, 0.2)',
                    borderColor: y.borderColor ?? 'rgba(54, 162, 235, 1)',
                    borderWidth: y.borderWidth ?? 1
                }
            });
            const ctx = this.$refs.chart.getContext('2d');
            new Chart(ctx, {
                type: this.type ?? 'line',
                data: {
                    labels: this.x_axis,
                    datasets: yAxis
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