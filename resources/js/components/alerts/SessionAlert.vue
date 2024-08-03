<template>
  <div>
    <!--<div @click="alertDisplay">test</div>-->
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'success',
    }
  },
  data() {
    return {
        notification: this.message,
        alertClass: this.type,
    }
  },
  created () {
    // This check will verify if another component has emitted an event to trigger notification
    let self = this;
    window.events.$on(
        'flash', data => self.flash(data)
    );
  },
  methods: {
    flash(data) {
      if (data) {
          this.notification = data.message;
          this.alertClass = data.type;
      }
      this.alertDisplay();
    },
    alertDisplay() {
        this.$swal.fire({
          position: 'top-end',
          icon: this.alertClass,
          title: this.notification,
          timerProgressBar: true,
          showConfirmButton: false,
          allowOutsideClick: true,
          allowEscapeKey: true,
          timer: 5000
        })
    },
  }
}
</script>
