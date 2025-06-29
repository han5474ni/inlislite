-- Sample data untuk tabel registrations
INSERT INTO registrations (library_name, province, city, email, phone, status, created_at, updated_at, verified_at) VALUES
-- Januari 2024
('Perpustakaan Nasional RI', 'DKI Jakarta', 'Jakarta Pusat', 'perpusnas@example.com', '021-1234567', 'verified', '2024-01-15 09:30:00', '2024-01-16 10:00:00', '2024-01-16 10:00:00'),
('Perpustakaan Kota Bandung', 'Jawa Barat', 'Bandung', 'perpuskotabdg@example.com', '022-1234567', 'verified', '2024-01-20 14:15:00', '2024-01-21 09:30:00', '2024-01-21 09:30:00'),
('Perpustakaan Universitas Gadjah Mada', 'DI Yogyakarta', 'Yogyakarta', 'perpus@ugm.ac.id', '0274-123456', 'pending', '2024-01-25 11:00:00', '2024-01-25 11:00:00', NULL),

-- Februari 2024
('Perpustakaan Universitas Indonesia', 'Jawa Barat', 'Depok', 'perpus@ui.ac.id', '021-7654321', 'verified', '2024-02-05 08:45:00', '2024-02-06 16:20:00', '2024-02-06 16:20:00'),
('Perpustakaan Daerah Jawa Timur', 'Jawa Timur', 'Surabaya', 'perpusdajatim@example.com', '031-1234567', 'verified', '2024-02-12 13:30:00', '2024-02-13 10:15:00', '2024-02-13 10:15:00'),
('Perpustakaan Institut Teknologi Bandung', 'Jawa Barat', 'Bandung', 'perpus@itb.ac.id', '022-2501234', 'pending', '2024-02-18 16:00:00', '2024-02-18 16:00:00', NULL),
('Perpustakaan Kota Medan', 'Sumatera Utara', 'Medan', 'perpuskotamedan@example.com', '061-1234567', 'verified', '2024-02-25 09:20:00', '2024-02-26 14:10:00', '2024-02-26 14:10:00'),

-- Maret 2024
('Perpustakaan Universitas Brawijaya', 'Jawa Timur', 'Malang', 'perpus@ub.ac.id', '0341-123456', 'verified', '2024-03-03 10:15:00', '2024-03-04 08:30:00', '2024-03-04 08:30:00'),
('Perpustakaan Daerah Bali', 'Bali', 'Denpasar', 'perpusdabali@example.com', '0361-123456', 'pending', '2024-03-10 14:45:00', '2024-03-10 14:45:00', NULL),
('Perpustakaan Universitas Padjadjaran', 'Jawa Barat', 'Bandung', 'perpus@unpad.ac.id', '022-1987654', 'verified', '2024-03-15 11:30:00', '2024-03-16 09:15:00', '2024-03-16 09:15:00'),
('Perpustakaan Kota Makassar', 'Sulawesi Selatan', 'Makassar', 'perpuskotamks@example.com', '0411-123456', 'pending', '2024-03-22 13:00:00', '2024-03-22 13:00:00', NULL),
('Perpustakaan Universitas Diponegoro', 'Jawa Tengah', 'Semarang', 'perpus@undip.ac.id', '024-1234567', 'verified', '2024-03-28 15:20:00', '2024-03-29 10:45:00', '2024-03-29 10:45:00'),

-- April 2024
('Perpustakaan Daerah Sumatera Barat', 'Sumatera Barat', 'Padang', 'perpusdasumbar@example.com', '0751-123456', 'verified', '2024-04-02 09:10:00', '2024-04-03 11:25:00', '2024-04-03 11:25:00'),
('Perpustakaan Universitas Airlangga', 'Jawa Timur', 'Surabaya', 'perpus@unair.ac.id', '031-5555555', 'pending', '2024-04-08 12:40:00', '2024-04-08 12:40:00', NULL),
('Perpustakaan Kota Palembang', 'Sumatera Selatan', 'Palembang', 'perpuskotaplg@example.com', '0711-123456', 'verified', '2024-04-14 16:30:00', '2024-04-15 09:00:00', '2024-04-15 09:00:00'),

-- Mei 2024
('Perpustakaan Universitas Hasanuddin', 'Sulawesi Selatan', 'Makassar', 'perpus@unhas.ac.id', '0411-555666', 'verified', '2024-05-05 08:15:00', '2024-05-06 14:30:00', '2024-05-06 14:30:00'),
('Perpustakaan Daerah Kalimantan Timur', 'Kalimantan Timur', 'Samarinda', 'perpusdakaltim@example.com', '0541-123456', 'pending', '2024-05-12 11:50:00', '2024-05-12 11:50:00', NULL),
('Perpustakaan Institut Pertanian Bogor', 'Jawa Barat', 'Bogor', 'perpus@ipb.ac.id', '0251-123456', 'verified', '2024-05-18 13:25:00', '2024-05-19 10:10:00', '2024-05-19 10:10:00'),
('Perpustakaan Kota Balikpapan', 'Kalimantan Timur', 'Balikpapan', 'perpuskotabpp@example.com', '0542-123456', 'verified', '2024-05-25 15:35:00', '2024-05-26 08:20:00', '2024-05-26 08:20:00'),

-- Juni 2024
('Perpustakaan Universitas Sebelas Maret', 'Jawa Tengah', 'Surakarta', 'perpus@uns.ac.id', '0271-123456', 'pending', '2024-06-01 09:45:00', '2024-06-01 09:45:00', NULL),
('Perpustakaan Daerah Sulawesi Utara', 'Sulawesi Utara', 'Manado', 'perpusdasulut@example.com', '0431-123456', 'verified', '2024-06-08 12:20:00', '2024-06-09 15:40:00', '2024-06-09 15:40:00'),
('Perpustakaan Kota Pontianak', 'Kalimantan Barat', 'Pontianak', 'perpuskotaptk@example.com', '0561-123456', 'verified', '2024-06-15 14:10:00', '2024-06-16 09:55:00', '2024-06-16 09:55:00');
