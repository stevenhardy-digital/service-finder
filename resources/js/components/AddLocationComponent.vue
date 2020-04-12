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
                        <div class="form-check">
                            <label for="Monday" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="Monday" v-model="openingHours">Monday</label>
                        </div>    
                        <div class="form-check"> 
                            <label for="Tuesday" class="form-check-label"><input type="checkbox" id="tues" class="form-check-input" value="Tuesday" v-model="openingHours">Tuesday</label>
                        </div>
                        <div class="form-check">
                            <label for="Wednesday" class="form-check-label"><input type="checkbox" id="wed" class="form-check-input" value="Wednesday" v-model="openingHours">Wednesday</label>        
                        </div>
                        <div class="form-check">
                            <label for="Thursday" class="form-check-label"><input type="checkbox" id="thurs" class="form-check-input" value="Thursday" v-model="openingHours">Thursday</label>        
                        </div>   
                        <div class="form-check">
                            <label for="Friday" class="form-check-label"><input type="checkbox" id="fri" class="form-check-input" value="Friday" v-model="openingHours">Friday</label>        
                        </div>   
                        <div class="form-check">
                            <label for="Saturday" class="form-check-label"><input type="checkbox" id="sat" class="form-check-input" value="Saturday" v-model="openingHours">Saturday</label>        
                        </div>   
                        <div class="form-check">
                            <label for="Sunday" class="form-check-label"><input type="checkbox" id="sun" class="form-check-input" value="Sunday" v-model="openingHours">Sunday</label>        
                        </div>      
                    </div>  
                    <div class="form-group">
                        <label>Logo or Image</label>
                        <input type="file" class="form-control" v-on:change="onImageChange">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Services</label>
                        <div class="form-check">
                            <label for="Home delivery" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="Home delivery" v-model="services">Home delivery</label>
                        </div>   
                        <div class="form-check">
                            <label for="Click and Collect" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="Click and Collect" v-model="services">Click and Collect</label>
                        </div>  
                        <div class="form-check">
                            <label for="Take away" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="Take away" v-model="services">Take away</label>
                        </div>
                        <div class="form-check">
                            <label for="Contact free" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="Contact free" v-model="services">Contact free</label>
                        </div>  
                        <div class="form-check">
                            <label for="Telephone Call" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="Telephone Call" v-model="services">Telephone Call</label>
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
                openingHours: [],
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
                services: []
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
        methods: {
            onImageChange(e){
                this.logo = e.target.files[0];
            },
            addLocation(e) {
                e.preventDefault();
                let currentObj = this;
 
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();

                formData.append('name', this.name);
                formData.append('location', this.location);
                formData.append('opening_hours', this.openingHours);
                formData.append('category', this.category);
                formData.append('logo', this.logo);
                formData.append('latitude', this.latLong.latitude);
                formData.append('longitude', this.latLong.longitude);
                formData.append('description', this.description);
                const services = this.services;

                services.forEach((item) => {
                    formData.append('services[]', item);
                });

                formData.append('phone', this.phone);
                formData.append('email', this.email);
 
                axios.post('/add-location', formData, config)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    currentObj.output = error;
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