export type UserForm = {
  first_name: string;
  last_name: string;
  email: string;
  owner: boolean;
  password: string;
  password_confirmation: string;
}

export type User = {
  id: number;
  first_name: string;
  last_name: string;
  name: string;
  email: string;
  owner: boolean;
  created_at: string;
};
