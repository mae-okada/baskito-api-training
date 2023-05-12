<template layout="admin">
  <Head title="Profile" />

  <PageSection header="Profile">
    <PageTitle>Your Profile</PageTitle>
    <PageDescription>Here you can edit your profile data.</PageDescription>

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
                    />
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <BKInput
                      id="email"
                      v-model="form.email"
                      type="email"
                      name="email"
                      maxlength="50"
                    />
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
                    />
                  </div>
                  <div class="form-group">
                    <label for="owner">Is Owner</label>
                    <select
                      id="owner"
                      v-model="form.owner"
                      class="form-control"
                      name="owner"
                    >
                      <option :value="true">Yes</option>
                      <option :value="false">No</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer text-right">
            <BKButton
              :color="form.isDirty ? 'danger' : 'secondary'"
              class="mr-3"
              :disabled="form.processing"
              @click="form.reset()"
            >
              Cancel
            </BKButton>
            <BKButton
              color="primary"
              :disabled="!form.isDirty"
              :loading="form.processing"
              loading-text="Saving..."
              @click="submit"
            >
              Save Changes
            </BKButton>
          </div>
        </div>
      </div>
    </div>
  </PageSection>
</template>

<script setup lang="ts">
import { BKButton, BKInput, useSweetAlert } from "@timedoor/baskito-ui";
import { useRoute } from "@/scripts/utils/ziggy/useRoute";
import PageDescription from "@/views/components/admin/layout/Page/PageDescription.vue";
import PageSection from "@/views/components/admin/layout/Page/PageSection.vue";
import PageTitle from "@/views/components/admin/layout/Page/PageTitle.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps<{
  profile: {
    first_name: string;
    last_name: string;
    email: string;
    owner: boolean;
  };
}>();

const form = useForm({
  first_name: props.profile.first_name,
  last_name: props.profile.last_name,
  email: props.profile.email,
  owner: props.profile.owner,
});

const { route } = useRoute();
const { successAlert } = useSweetAlert();

const submit = () => {
  form.put(route("admin.profile.update"), {
    preserveScroll: true,
    onSuccess: () => {
      successAlert({ title: "Profile updated successfully!" });
    },
  });
};
</script>

<style scoped>
.profile-card {
  max-width: 720px;
}
</style>
