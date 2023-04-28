<template layout="admin">
  <Head title="Users Page" />

  <PageSection header="Manage Users">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header justify-content-between">
            <h4>Users List</h4>
            <div class="card-header-form">
              <form method="get" @submit.prevent="search">
                <div class="input-group">
                  <BKInput
                    v-model="form.filter.search"
                    name="search"
                    placeholder="Search"
                    class="form-control"
                  />
                  <div class="input-group-btn">
                    <BKButton type="submit" variant="primary">
                      <i class="fas fa-search"></i>
                    </BKButton>
                  </div>
                </div>
              </form>
            </div>
            <BKLinkButton
              class="ml-2"
              variant="primary"
              :href="$route('admin.user.create')"
            >
              Add New User
            </BKLinkButton>
          </div>
          <div class="card-body">
            <table class="table table-striped">
              <Head>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Is Owner</th>
                  <th>Register At</th>
                  <th>Action</th>
                </tr>
              </Head>
              <tbody>
                <tr v-if="users.data.length === 0">
                  <td colspan="6" class="text-center">No data available</td>
                </tr>
                <tr v-for="(user, index) in users.data" :key="user.id">
                  <td>{{ index + users.meta.from }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <span
                      class="badge"
                      :class="{
                        'badge-success': user.owner,
                        'badge-danger': !user.owner,
                      }"
                    >
                      {{ user.owner ? "Yes" : "No" }}
                    </span>
                  </td>
                  <td>{{ dayjs(user.created_at).format("MMM DD, YYYY") }}</td>
                  <td class="buttons">
                    <BKLinkButton
                      :href="$route('admin.user.edit', user.id)"
                      variant="warning"
                    >
                      Edit
                    </BKLinkButton>
                    <BKButton variant="danger" @click="deleteUser(user)">
                      Delete
                    </BKButton>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer text-right">
            <BKPagination class="d-inline-block" :links="users.meta.links" />
          </div>
        </div>
      </div>
    </div>
  </PageSection>
</template>

<script setup lang="ts">
import { BKButton, BKInput, BKLinkButton, BKPagination, useSweetAlert } from "@timedoor/baskito-ui";
import { useAxios } from "@/scripts/composables/useAxios";
import type { BKResourceCollection } from "@timedoor/baskito-ui";
import { useRoute } from "@/scripts/utils/ziggy/useRoute";
import PageSection from "@/views/components/admin/layout/Page/PageSection.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { AxiosError } from "axios";
import dayjs from "dayjs";

type User = {
  id: number;
  first_name: string;
  last_name: string;
  name: string;
  email: string;
  owner: boolean;
  created_at: string;
};

const props = defineProps<{
  users: BKResourceCollection<User>;
  filter: {
    search?: string;
  };
}>();

const form = useForm({
  filter: {
    search: props.filter.search || "",
  },
});

const { warningAlert, successAlert } = useSweetAlert();
const { route } = useRoute();

const search = () => {
  form.get(route("admin.user.index"), {
    preserveState: true,
    preserveScroll: true,
  });
};

const deleteUser = async (user: User) => {
  const confirm = await warningAlert({
    title: "Are you sure?",
    text: `You're trying to delete user ${user.name}.
    You won't be able to revert this!`,
    dangerMode: true,
    buttons: ["Cancel", "Yes, delete it!"],
  });

  if (!confirm) {
    return;
  }

  useAxios(
    route("admin.user.destroy", user.id),
    { method: "DELETE" },
    {
      immediate: true,
      onSuccess: () => {
        successAlert({
          title: "Deleted!",
          text: `User ${user.name} has been deleted.`,
          icon: "success",
        });

        router.reload();
      },
      onError: (error) => {
        let text = `Failed to delete user ${user.name}.`;

        if (error instanceof AxiosError) {
          switch (error.response?.status) {
            case 404:
              text = `User ${user.name} not found.`;
              break;
            case 403:
              text = `You're not allowed to delete user ${user.name}.`;
              break;
            default:
              break;
          }
        }

        warningAlert({ title: "Failed!", text: text, icon: "error" });
      },
    }
  );
};
</script>
