<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="">
                    <div class="form-group">
                        <input type="text" placeholder="Напишите здесь заголовок" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    $data = "MAMA!";
    export default {
        name: "CreatePostPage"
    }
</script>

<style scoped>

</style>
