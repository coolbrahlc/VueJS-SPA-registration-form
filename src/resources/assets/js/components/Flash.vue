<template>
    <transition name="fade" >

            <div class='alert alert-flash'
                 :class="'alert-' + type"
                 role='alert'
                 v-if='show'>

                <div v-if="Array.isArray(messageBody)">
                    <div v-for="message in messageBody">
                        {{message}}
                    </div>
                </div>
                <div v-else>{{messageBody}}</div>
            </div>

    </transition>
</template>

<script>
    export default {
        name: 'Flash',
        data() {
            return {
                messageBody: '',
                show: false,
                type: ''
            }
        },
        created() {
            window.events.$on('flash', (messageBody, type) => {

                this.messageBody = messageBody;
                this.type = type;
                this.show = true;
                setTimeout(() => {
                    this.show = false;
                }, 4000)
            });
        },
    }
</script>