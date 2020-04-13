<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <h1>Add location</h1>
                <form @submit="addLocation" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" v-model="name" />
                    </div>
                    <div class="form-group">
                        <label>Location:</label>
                        <input type="text" class="form-control" v-model="location" v-on:blur="getLongLat()"/>
                    </div>
                    <div class="form-group">
                        <label>Phone Number:</label>
                        <input type="text" class="form-control" v-model="phone" />
                    </div>
                    <div class="form-group">
                        <label>Email Address:</label>
                        <input type="email" class="form-control" v-model="email" />
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select v-model="category" class="form-control">
                            <option v-for="category in categories" :key="category.id">{{category.name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Opening Hours</label>
                        <div class="form-group" v-for="day in days" :key="day">
                            <label :for="day" class="form-check-label">{{day}}</label>
                            <div class="form-roq">
                                <label>Open Time</label>
                                <input type="text" v-model="opening_times[day]['open_time']"/>
                                <label>Close Time</label>
                                <input type="text" v-model="opening_times[day]['close_time']" />
                            </div>
                        </div>    
                    </div>  
                    <div class="form-group">
                        <label>Logo or Image</label>
                        <input type="text" class="form-control" v-model="logo">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Services</label>
                        <div class="form-check" v-for="service in services" :key="service">
                            <label :for="service" class="form-check-label"><input type="checkbox" class="form-check-input"  v-model="location_services[service]">{{service}}</label>
                        </div>
                    </div>
                    <button class="btn btn-success">Submit</button>
                </form>
                <div class="success alert-success" v-if="success">
                    {{success}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import GoogleMapsApiLoader from 'google-maps-api-loader'
    export default {
        data() {
            return {
                categories: [],
                name: '',
                location: '',
                opening_times: {
                    Monday: {
                        day: 'Monday',
                        open_time: null,
                        close_time: null
                    },
                    Tuesday: {
                        day: 'Tuesday',
                        open_time: null,
                        close_time: null
                    },
                    Wednesday: {
                        day: 'Wednesday',
                        open_time: null,
                        close_time: null
                    },
                    Thursday: {
                        day: 'Thursday',
                        open_time: null,
                        close_time: null
                    },
                    Friday: {
                        day: 'Friday',
                        open_time: null,
                        close_time: null
                    },
                    Saturday: {
                        day: 'Saturday',
                        open_time: null,
                        close_time: null
                    },
                    Sunday: {
                        day: 'Sunday',
                        open_time: null,
                        close_time: null
                    },
                } ,
                category: '',
                logo: '',
                success: '',
                google: '',
                latLong: {
                    latitude: '',
                    longitude: ''
                },
                description: '',
                phone: '',
                email: '',
                location_services: {},
                services: ['Home delivery', 'Click and Collect', 'Take away', 'Contact free', 'Telephone Call'], 
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
            }
        },
        async mounted() {
            const googleMapApi = await GoogleMapsApiLoader({
            apiKey: process.env.MIX_GOOGLE_API
            })
            this.google = googleMapApi

            axios
            .get('/category/all')
            .then(response => (this.categories = response.data))
        },
        computed: {
            
            formData() {
                return {
                    opening_times: this.opening_times,
                    name: this.name,
                    location: this.location,
                    category: this.category,
                    logo: this.logo,
                    latitude: this.latLong.latitude,
                    longitude: this.latLong.longitude,
                    description: this.description,
                    services: this.location_services,
                    phone: this.phone,
                    email: this.email
                }    
            }
            
        },
        methods: {
            addLocation(e) {
                e.preventDefault();

                let current = this;
 
                axios.post('/add-location', this.formData)
                .then(function (response) {
                    current.success = response.data.success;
                })
                .catch(function (error) {
                    current.output = error;
                });
            },
            getLongLat() {

                let geocoder = new google.maps.Geocoder();
                let latLong = this.latLong;
                
                geocoder.geocode({'address': this.location}, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        latLong.latitude = results[0].geometry.location.lat()
                        latLong.longitude = results[0].geometry.location.lng()
                    } else {
                        console.log(status)
                    }
               });
            }
        }

    }
</script>