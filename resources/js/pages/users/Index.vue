<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { EllipsisVertical } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '../../components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../components/ui/table';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard.index'),
    },
    {
        title: 'Users',
        href: route('users.index'),
    },
];

const dialogOpen = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const { dataUser } = defineProps({
    dataUser: {
        type: Object,
        required: true,
    },
});

const submit = () => {
    form.post(route('users.simpan'), {
        onSuccess: () => {
            dialogOpen.value = false;
            toast('User berhasil ditambahkan');
        },
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-lg">Data User</h1>
                <Button @click="dialogOpen = true">Tambah</Button>
            </div>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>No</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Created Date</TableHead>
                        <TableHead>Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="(user, index) in dataUser.data" :key="user.id">
                        <TableCell>{{ index + 1 }}</TableCell>
                        <TableCell>{{ user.name }}</TableCell>
                        <TableCell>{{ user.email }}</TableCell>
                        <TableCell>{{ user.created_at }}</TableCell>
                        <TableCell>
                            <DropdownMenu>
                                <DropdownMenuTrigger><EllipsisVertical /></DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuLabel>Action</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem>Edit</DropdownMenuItem>
                                    <DropdownMenuItem>Hapus</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <Dialog v-model:open="dialogOpen">
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>Edit profile</DialogTitle>
                    <DialogDescription> Make changes to your profile here. Click save when you're done. </DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submit" class="grid gap-y-4">
                    <div class="grid gap-y-1">
                        <Label for="name" class="text-sm">Name</Label>
                        <Input id="name" type="text" class="col-span-3" v-model="form.name" placeholder="ex. Fulan" />
                    </div>
                    <div class="grid gap-y-1">
                        <Label for="email" class="text-sm">Email</Label>
                        <Input id="email" type="email" class="col-span-3" v-model="form.email" placeholder="ex. fulan@gmail.com" />
                    </div>
                    <div class="grid gap-y-1">
                        <Label for="password" class="text-sm">Password</Label>
                        <Input id="password" type="password" class="col-span-3" v-model="form.password" placeholder="***" />
                    </div>
                    <div class="grid gap-y-1">
                        <Label for="password_confirmation" class="text-sm">Password Confirmation</Label>
                        <Input id="password_confirmation" type="password" class="col-span-3" v-model="form.password_confirmation" placeholder="***" />
                    </div>
                    <DialogFooter class="mt-6">
                        <Button type="submit">Save</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>

<style scoped></style>
