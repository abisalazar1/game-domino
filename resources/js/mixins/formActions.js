export default {
    computed: {
      formHasErrors() {
        return !!this.form.errors.length;
      },
    },
    data: () => ({
      formStructure: {},
      formFistState: {},
      form: {
        data: {},
        errors: [],
      }
    }),
    methods: {
      formHasError(value) {
        return !!this.form.errors.hasOwnProperty(value);
      },
      formGetError(value) {
        if (!this.form.errors.hasOwnProperty(value)) return;
        return this.form.errors[value][0];
      },
      setFormErrors({ errors, message }) {
        if (errors) {
          this.form.errors = errors;
        }
      },
      resetFormErrors() {
        this.form.errors = [];
      },
      setFormStructure(data) {
        this.form = this.$helpers.unbind({
          ...this.form,
          data
        });
        this.setFormFirstState();
      },
      setFormFirstState() {
        this.formFistState = this.$helpers.unbind({
          ...this.form
        });
      },
      resetForm() {
        this.form = this.$helpers.unbind({
          ...this.formFistState
        });
      }
    },
    mounted() {
      this.setFormStructure(this.formStructure);
    }
  }