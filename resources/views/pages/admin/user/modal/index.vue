<template layout="admin">
  <Head title="Users Page" />

  <PageSection header="Users With Modal">
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
                    <BKButton type="submit" color="primary">
                      <i class="fas fa-search"></i>
                    </BKButton>
                  </div>
                </div>
              </form>
            </div>
            <BKButton
              class="ml-2"
              color="primary"
              data-target="#create-user-modal"
              data-toggle="modal"
            >
              Add New User
            </BKButton>
          </div>
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Is Owner</th>
                  <th>Register At</th>
                  <th>Action</th>
                </tr>
              </thead>
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
                    <BKButton
                      color="warning"
                      data-target="#edit-user-modal"
                      data-toggle="modal"
                      @click="editUser(user)"
                    >
                      Edit
                    </BKButton>
                    <BKButton color="danger" @click="deleteUser(user)">
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

  <Teleport to="body">
    <CreateModal />
    <EditModal ref="editModal" />
  </Teleport>
</template>

<script setup lang="ts">
import { useAxios } from "@/scripts/composables/useAxios";
import { User } from "@/scripts/types/admin/user";
import { useRoute } from "@/scripts/utils/ziggy/useRoute";
import PageSection from "@/views/components/admin/layout/Page/PageSection.vue";
import CreateModal from "@/views/components/admin/pages/user/modal/CreateModal.vue";
import EditModal from "@/views/components/admin/pages/user/modal/EditModal.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import type { BKResourceCollection } from "@timedoor/baskito-ui";
import {
  BKButton,
  BKInput,
  BKPagination,
  useSweetAlert,
} from "@timedoor/baskito-ui";
import { AxiosError } from "axios";
import dayjs from "dayjs";
import { ref } from "vue";

const props = defineProps<{
  users: BKResourceCollection<User>;
  filter: {
    search?: string;
  };
}>();

let editModal = ref<InstanceType<typeof EditModal>>();

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

const editUser = (user: User) => {
  editModal.value?.setEditModalForm(user);
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
