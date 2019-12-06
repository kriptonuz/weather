<template>
    <div class="container">
        <div class="row justify-content-center vh-100">
            <div class="col stretch-card align-self-center">
                <!--weather card-->
                <div class="card card-weather">
                    <div class="card-body">
                        <div class="weather-date-location">
                            <h3>{{current.day}}</h3>
                            <p class="text-gray"> <span class="weather-date">{{current.date}}</span> <span class="weather-location">{{city}}</span> </p>
                        </div>
                        <div class="dropdown">
                            <v-select v-model="city" :options="['tashkent', 'moscow', 'london']" @input="update"></v-select>
                        </div>
                        <div class="weather-data d-flex">
                            <div class="mr-auto">
                                <h4 class="display-3">{{current.temp}} <span class="symbol">°</span>C</h4>
                                <p>{{current.phrase}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex weakly-weather">
                            <div class="weakly-weather-item" v-for="item in forecast" v-bind:key="item.date">
                                <p class="mb-1"> {{window.moment(item.date).format('ddd')}} </p>
                                <p class="mb-0"> {{item.day.temp}} <span class="symbol">°</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--weather card ends-->
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Weather",
        data: function () {
            return {
                urldata: [],
                city: 'tashkent',
                current: {
                    day: '',
                    date: '',
                    temp: '',
                    phrase: '',
                },
                forecast: [],
                window: window
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update: function (city = 'tashkent') {
                window.axios.get('http://localhost:8080/city/' + city).then((response) => {
                    this.urldata = response.data
                    this.current = response.data.current
                    this.current.day = window.moment.unix(response.data.current.date).format('dddd')
                    this.current.date = window.moment.unix(response.data.current.date).format('MMMM Do')
                    this.city = response.data.city
                    this.forecast = response.data.forecast
                    console.log(response.data)
                })
            }
        }
    }
</script>

<style>
    .stretch-card>.card {
        width: 100%;
        min-width: 100%
    }

    body {
        background-color: #f9f9fa
    }

    .purchace-popup>div {
        margin-bottom: 25px
    }

    .card {
        border: 0;
        border-radius: 2px
    }

    .card-weather {
        background: #e1ecff linear-gradient(to left bottom, #d6eef6, #dff0fa, #e7f3fc, #eff6fe, #f6f9ff);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem
    }

    .card-weather .card-body:first-child {
        background: url(https://res.cloudinary.com/dxfq3iotg/image/upload/v1557323760/weather.svg) no-repeat center;
        background-size: cover
    }

    .card .card-body {
        padding: 1.88rem 1.81rem
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem
    }

    .card-weather .weather-date-location {
        padding: 0 0 38px
    }

    h3 {
        font-size: 1.56rem
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Poppins", sans-serif;
        font-weight: 500
    }

    .text-gray{
        color: #969696
    }

    p {
        font-size: 13px
    }


    .card-weather .weather-data {
        padding: 0 0 4.75rem
    }



    .display-3 {
        font-size: 2.5rem
    }

    .card-weather .card-body {
        background: #ffffff
    }

    .card-weather .weakly-weather {
        background: #ffffff;
        overflow-x: auto
    }

    .card-weather .weakly-weather .weakly-weather-item {
        flex: 0 0 20%;
        border-right: 1px solid #f2f2f2;
        padding: 1rem;
        text-align: center
    }

    .mr-auto{
        margin-right: auto !important
    }

    .mb-0{
        margin-bottom: 0 !important
    }

    .card-weather .weakly-weather .weakly-weather-item i {
        font-size: 1.2rem
    }
</style>