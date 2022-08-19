@extends('layout.master')
@section('title')
<title>Append Comment</title>
@endsection
@section('content')
<section id="main">
    <header>
        <form action="#">
            @csrf
            <div v-if="errorMessage" class="error-message">
                <p>@{{errorMessage}}</p>
            </div>
            <div class="form-group">
                <label for="">Select User</label>
                <select class="form-control" v-model="user.id" @change="setComment()">
                    <option :value="user.id" v-for="(user, index) in users"> @{{ user.name }}</option>
                </select>
                <div v-if="errorBag.id" class="error-message">
                    <ul>
                        <li class="text-danger" v-for="(idError, idIndex) in errorBag.id" :key="idIndex">@{{idError}}</li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="">Append Comment</label>
                <textarea class="form-control" cols="20" rows="5" v-model="user.comments"></textarea>
                <div v-if="errorBag.comments" class="error-message">
                    <ul>
                        <li class="text-danger" v-for="(commentsError, commentsIndex) in errorBag.comments" :key="commentsIndex">@{{commentsError}}</li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <button type="buttom" class="button" :disabled="isLoading" @click="submit">Submit</button>
            </div>
        </form>
    </header>
</section>
<textarea style="display:none" id="users" >{{ json_encode($users) }} </textarea>
<textarea style="display:none" id="update-url" >{{ route('update-comment') }} </textarea>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="/js/app.js"></script>

{{-- <script>
    
</script> --}}
@endsection