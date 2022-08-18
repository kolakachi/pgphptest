new Vue({
    el: "#main",
    data : {
        isLoading: false,
        errorBag:{},
        errorMessage:"",
        users:[],
        user:{
            id:0,
            comments:"",
            password:"720DF6C2482218518FA20FDC52D4DED7ECC043AB"
        },
        url:{
            update: '',
        },
    },
    mounted() {
        this.url.update = $('#update-url').val();
        this.users = JSON.parse($('#users').val());

    },
    methods: {
        setComment(){
            for(let key in this.users){
                if (this.user.id === this.users[key].id) {
                    this.user.comments = Object.assign({}, this.users[key]).comments;
                }
            }
        },
        submit(){
            const formData = new FormData();
            for(var key in this.user){
                formData.append(key, this.user[key]);
            }
            formData.append("_token", $("input[name=_token]").val());
    
            this.isLoading = true;
            this.errorBag = {};
            this.errorMessage="";
            axios.post(this.url.update, formData)
                .then((response) => {
                    this.isLoading = false;
                    var updatedUser = response.data.user;

                    this.users = this.users.map((user, index) => {
                        if (user.id === updatedUser.id) {
                            user = Object.assign({}, updatedUser);
                        }
                        return user;
                    });

                    this.user.comments = updatedUser.comments;
                })
                .catch((error) => {
                    console.log(error);
                    if(error.response.status == 422){
                        this.errorBag = error.response.data.errors
                    }
                    this.errorMessage = error.response.data.message;

                    this.isLoading = false;
                    
                });
        },
    }
})