<template layout="admin">
  <Head title="Dashboard" />

  <PageSection header="Dashboard Page" :back-link="$route('admin.dashboard')">
    <PageTitle>Dashboard</PageTitle>
    <PageDescription>Description for the page.</PageDescription>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ hasRole("superadmin") ? "Admin" : "User" }}</h4>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Permission</th>
                  <th>Value</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Can Create User</td>
                  <td v-if="hasPermission('create.users')">
                    <span class="badge badge-success">True</span>
                  </td>
                  <td v-else><span class="badge badge-danger">False</span></td>
                </tr>
                <tr>
                  <td>Can View User</td>
                  <td v-if="hasPermission('view.users')">
                    <span class="badge badge-success">True</span>
                  </td>
                  <td v-else><span class="badge badge-danger">False</span></td>
                </tr>
                <tr>
                  <td>Can Edit User</td>
                  <td v-if="hasPermission('edit.users')">
                    <span class="badge badge-success">True</span>
                  </td>
                  <td v-else><span class="badge badge-danger">False</span></td>
                </tr>
                <tr>
                  <td>Can Delete User</td>
                  <td v-if="hasPermission('delete.users')">
                    <span class="badge badge-success">True</span>
                  </td>
                  <td v-else><span class="badge badge-danger">False</span></td>
                </tr>
                <tr>
                  <td>Can Create & Delete User</td>
                  <td
                    v-if="hasPermission(['delete.users', 'create.users'], true)"
                  >
                    <span class="badge badge-success">True</span>
                  </td>
                  <td v-else><span class="badge badge-danger">False</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </PageSection>
</template>

<script setup lang="ts">
import { useRole } from "@/scripts/utils/role";
import PageDescription from "@components/admin/layout/Page/PageDescription.vue";
import PageSection from "@components/admin/layout/Page/PageSection.vue";
import PageTitle from "@components/admin/layout/Page/PageTitle.vue";
import { Head, usePage } from "@inertiajs/vue3";

const { hasRole, hasPermission } = useRole(usePage().props.auth?.user);
</script>

<style scoped></style>
