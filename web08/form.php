<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>台北101接駁專車搭乘意願調查</title>
    <?php include 'link.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>
    <div id="app" class="container mt-4">
        <h2 class="mb-4 text-center">接駁車意願調查</h2>
      
        <form v-if="formEnabled" @submit.prevent="submitForm">
          <table class="w-30 mx-auto">    <td class="form-text"><h4>姓名</h4></td>
            <td><input type="text" name="name" v-model="name" id="name" required class="form-control mt-2"></td></tr>
            
            <td class="form-text"><h4>信箱</h4></td>
            <td><input type="text" name="email" v-model="email" id="email" size="60" required class="form-control mt-2">
           <p></p> <button type="submit" class="btn btn-primary btn-block">提交</button></td></tr>
</table> </form>
        <div v-else>
            <p>該表單目前不接受回應</p>
        </div>
        <div v-if="message" class="mt-3">
            <p>{{ message }}</p>
        </div>
    </div>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    name: '',
                    email: '',
                    message: '',
                    formEnabled: true
                };
            },
            mounted() {
                this.checkForm();
            },
            methods: {
                checkForm() {
                    fetch('./api/form.php?type=settings')
                        .then(response => response.json())
                        .then(data => {
                            this.formEnabled = data.form_enabled;
                        });
                },
                submitForm() {
                    fetch('./api/form.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: this.name,
                            email: this.email
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.message = data.message;
                        if (data.message === "感謝您的參與") {
                            this.name = '';
                            this.email = '';
                        }
                    });
                }
            }
        });

        app.mount('#app');
    </script>
</body>
</html>
