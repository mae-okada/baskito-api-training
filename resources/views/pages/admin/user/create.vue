<template layout="admin">
  <Head title="Add New User" />

  <PageSection header="Add New User" :back-link="$route('admin.user.index')">
    <PageTitle>New User</PageTitle>
    <PageDescription>Here you can create a new user.</PageDescription>

    <div class="row justify-content-center">
      <div class="col-xl-8 profile-card">
        <div class="card">
          <div class="card-body">
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
                      :class="{
                        'is-invalid': !!form.errors.password_confirmation,
                      }"
                    />
                    <ValidationFeedback
                      :message="form.errors.password_confirmation"
                    />
                  </div>
                </div>
                <div class="col-12 text-right">
                  <BKButton
                    :color="form.isDirty ? 'danger' : 'secondary'"
                    class="mr-3"
                    :disabled="form.processing"
                    tabindex="7"
                    type="button"
                    @click="resetForm"
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
          </div>
        </div>
      </div>
    </div>
  </PageSection>
</template>

<script setup lang="ts">
import { useRoute } from "@/scripts/utils/ziggy/useRoute";
import PageDescription from "@/views/components/admin/layout/Page/PageDescription.vue";
import PageSection from "@/views/components/admin/layout/Page/PageSection.vue";
import PageTitle from "@/views/components/admin/layout/Page/PageTitle.vue";
import ValidationFeedback from "@/views/components/admin/ui/Form/ValidationFeedback.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { BKButton, BKInput, useSweetAlert } from "@timedoor/baskito-ui";

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
  form.post(route("admin.user.store"), {
    preserveScroll: true,
    onSuccess: () => {
      successAlert({ title: "User created successfully!" });
    },
  });
};

const resetForm = () => {
  form.reset();
  form.clearErrors();
};
</script>

<style scoped>
.profile-card {
  max-width: 720px;
}
</style>
