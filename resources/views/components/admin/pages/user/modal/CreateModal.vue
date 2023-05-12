<template>
  <BKModal
    id="create-user-modal"
    title="Add New User"
    is-center
    @hidden="resetForm"
  >
    <form method="post" class="form" @submit.prevent="submit">
      <div class="row">
        <div class="col-6">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <BKInput
              id="firstName"
              v-model="form.first_name"
              name="first_name"
              maxlength="25"
              tabindex="1"
              :class="{ 'is-invalid': !!form.errors.first_name }"
            />
            <ValidationFeedback :message="form.errors.first_name" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <BKInput
              id="email"
              v-model="form.email"
              type="email"
              name="email"
              maxlength="50"
              tabindex="3"
              :class="{ 'is-invalid': !!form.errors.email }"
            />
            <ValidationFeedback :message="form.errors.email" />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <BKInput
              id="password"
              v-model="form.password"
              type="password"
              name="password"
              maxlength="50"
              tabindex="5"
              :class="{ 'is-invalid': !!form.errors.password }"
            />
            <ValidationFeedback :message="form.errors.password" />
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <BKInput
              id="lastName"
              v-model="form.last_name"
              name="last_name"
              maxlength="25"
              tabindex="2"
              :class="{ 'is-invalid': !!form.errors.last_name }"
            />
            <ValidationFeedback :message="form.errors.last_name" />
          </div>
          <div class="form-group">
            <label for="owner">Is Owner</label>
            <select
              id="owner"
              v-model="form.owner"
              class="form-control"
              name="owner"
              tabindex="4"
              :class="{ 'is-invalid': !!form.errors.owner }"
            >
              <option :value="true">Yes</option>
              <option :value="false">No</option>
            </select>
            <ValidationFeedback :message="form.errors.owner" />
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <BKInput
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              name="password_confirmation"
              maxlength="50"
              tabindex="6"
              :class="{ 'is-invalid': !!form.errors.password_confirmation }"
            />
            <ValidationFeedback :message="form.errors.password_confirmation" />
          </div>
        </div>
        <div class="col-12 text-right">
          <BKButton
            :color="form.isDirty ? 'danger' : 'secondary'"
            class="mr-3"
            :disabled="form.processing"
            tabindex="7"
            type="button"
            data-dismiss="modal"
          >
            Cancel
          </BKButton>
          <BKButton
            color="primary"
            :disabled="!form.isDirty"
            :loading="form.processing"
            loading-text="Saving..."
            tabindex="8"
            type="submit"
          >
            Create
          </BKButton>
        </div>
      </div>
    </form>

    <template #footer>
      <!-- need props in BKModal to hide footer modal -->
      <div></div>
    </template>
  </BKModal>
</template>

<script setup lang="ts">
import { useRoute } from "@/scripts/utils/ziggy/useRoute";
import ValidationFeedback from "@components/admin/ui/Form/ValidationFeedback.vue";
import { useForm } from "@inertiajs/vue3";
import { BKModal, useSweetAlert } from "@timedoor/baskito-ui";

const form = useForm({
  first_name: "",
  last_name: "",
  email: "",
  owner: false,
  password: "",
  password_confirmation: "",
});

const { route } = useRoute();
const { successAlert } = useSweetAlert();

const submit = () => {
  form.post(route("admin.user.store", { reload: true }), {
    preserveScroll: true,
    onSuccess: () => {
      $("#create-user-modal").modal("hide");
      successAlert({ title: "User created successfully!" });
    },
  });
};

const resetForm = () => {
  form.reset();
  form.clearErrors();
};
</script>

<style scoped></style>
