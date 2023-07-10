import { RoleType } from "@/scripts/utils/role";

declare module "@inertiajs/core" {
  interface PageProps {
    flash: FlashMessage;
    auth?: AuthProps;
  }
}

export type FlashMessage = {
  message: null | string;
};

export interface AuthProps {
  user: {
    id: number;
    name: string;
    email: string;
    role: RoleType;
  };
}
