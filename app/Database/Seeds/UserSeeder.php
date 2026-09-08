<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'admin@example.com',
                'username' => 'admin',
                'full_name' => 'Administrator',
                'phone' => '081234567890',
                'address' => 'Jakarta, Indonesia',
                'role' => 'admin',
                'status' => 'active',
                'password_hash' => password_hash('Admin123456', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'user@example.com',
                'username' => 'user123',
                'full_name' => 'Regular User',
                'phone' => '082345678901',
                'address' => 'Bandung, Indonesia',
                'role' => 'user',
                'status' => 'active',
                'password_hash' => password_hash('User123456', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'admin2@example.com',
                'username' => 'admin2',
                'full_name' => 'Administrator 2',
                'phone' => '083456789012',
                'address' => 'Surabaya, Indonesia',
                'role' => 'admin',
                'status' => 'active',
                'password_hash' => password_hash('Admin234567', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
