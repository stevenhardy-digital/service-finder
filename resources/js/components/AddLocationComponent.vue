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
                        <label>Category</label>
                        <select v-model="category" class="form-control">
                            <option v-for="category in categories">{{category.name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Opening Hours</label>
                        <div class="form-check">
                            <label for="Monday" class="form-check-label"><input type="checkbox" id="mon" class="form-check-input" value="mon" v-model="openingHours">Monday</label>
                        </div>    
                        <div class="form-check"> 
                            <label for="Tuesday" class="form-check-label"><input type="checkbox" id="tues" class="form-check-input" value="tues" v-model="openingHours">Tuesday</label>
                        </div>
                        <div class="form-check">
                            <label for="Wednesday" class="form-check-label"><input type="checkbox" id="wed" class="form-check-input" value="wed" v-model="openingHours">Wednesday</label>        
                        </div>
                        <div class="form-check">
                            <label for="Thursday" class="form-check-label"><input type="checkbox" id="thurs" class="form-check-input" value="thurs" v-model="openingHours">Thursday</label>        
                        </div>   
                        <div class="form-check">
                            <label for="Friday" class="form-check-label"><input type="checkbox" id="fri" class="form-check-input" value="fri" v-model="openingHours">Friday</label>        
                        </div>   
                        <div class="form-check">
                            <label for="Saturday" class="form-check-label"><input type="checkbox" id="sat" class="form-check-input" value="sat" v-model="openingHours">Saturday</label>        
                        </div>   
                        <div class="form-check">
                            <label for="Sunday" class="form-check-label"><input type="checkbox" id="sun" class="form-check-input" value="sun" v-model="openingHours">Sunday</label>        
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
                description: ''
            }
        },
        async mounted() {
            const googleMapApi = await GoogleMapsApiLoader({
            apiKey: process.env.MIX_GOOGLE_API
            })
            this.google = googleMapApi

            axios
            .get('http://service.test/category/all')
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