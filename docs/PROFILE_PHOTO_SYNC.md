# Profile Photo Synchronization

This document describes the profile photo synchronization system between the `users` and `profile` tables.

## Overview

The system now synchronizes profile photos between two tables:
- **users.avatar** - Avatar/photo filename in users table
- **profile.foto** - Profile photo filename in profile table

## Database Changes

### Migration 002: Add Avatar Column to Users Table

**File:** `database/migrations/002_add_avatar_to_users_table.sql`

**Changes:**
1. Adds `avatar` VARCHAR(255) column to `users` table
2. Adds index for the avatar column
3. Migrates existing photo data from `profile.foto` to `users.avatar`
4. Updates database triggers for bi-directional synchronization

### Updated Triggers

**Synchronization Triggers:**
- `sync_profile_on_user_insert` - Creates profile when user is created (includes avatar)
- `sync_profile_on_user_update` - Updates profile when user is updated (includes avatar)
- `sync_user_on_profile_update` - Updates user when profile is updated (NEW!)
- `sync_profile_on_user_delete` - Deletes profile when user is deleted

## Code Changes

### UserModel Updates

**New Fields:**
- Added `avatar` to `$allowedFields`

**New Methods:**
- `processUserData($user)` - Adds avatar_url and avatar_initials to user data
- `updateAvatar($userId, $avatarFilename)` - Updates user avatar and syncs to profile

### ProfileModel Updates

**Updated Methods:**
- `updatePhoto($id, $photoFilename)` - Now syncs photo to users table
- `updateProfileAndSync($profileId, $data)` - Now includes foto/avatar sync

## Usage

### Updating Profile Photos

**From Profile:**
```php
$profileModel = new \App\Models\ProfileModel();
$profileModel->updatePhoto($profileId, 'new_photo.jpg');
// Automatically syncs to users.avatar
```

**From User:**
```php
$userModel = new \App\Models\UserModel();
$userModel->updateAvatar($userId, 'new_photo.jpg');
// Automatically syncs to profile.foto
```

### Getting Avatar URLs

**Via UserModel:**
```php
$user = $userModel->find($userId);
$user = $userModel->processUserData($user);
echo $user['avatar_url']; // Full URL to avatar
echo $user['avatar_initials']; // Fallback initials
```

**Via ProfileModel:**
```php
$profile = $profileModel->getProfileWithFormatting($profileId);
echo $profile['foto_url']; // Full URL to photo
echo $profile['avatar_initials']; // Fallback initials
```

## Running the Migration

### Method 1: Using Migration Script
```bash
php scripts/run_migration_002.php
```

### Method 2: Manual SQL Execution
Execute the SQL file directly in your database:
```sql
source database/migrations/002_add_avatar_to_users_table.sql
```

## Testing

Run the test script to verify synchronization:
```bash
php scripts/test_photo_sync.php
```

**Test Results Should Show:**
- ✓ Current sync status between tables
- ✓ ProfileModel.updatePhoto() synchronization
- ✓ UserModel.updateAvatar() synchronization

## File Structure

```
database/migrations/
├── 001_create_profile_table.sql    # Original profile table
└── 002_add_avatar_to_users_table.sql   # NEW: Avatar sync migration

scripts/
├── run_migration_002.php           # Migration runner
└── test_photo_sync.php             # Sync test script

app/Models/
├── UserModel.php                   # Updated with avatar methods
└── ProfileModel.php               # Updated with sync methods
```

## Compatibility

- **Backward Compatible:** Existing `profile.foto` continues to work
- **Forward Compatible:** New `users.avatar` field is synchronized
- **View Compatibility:** Views can use either `foto_url` or `avatar_url`

## Troubleshooting

### Check Sync Status
```sql
SELECT u.id, u.nama_lengkap, u.avatar, p.foto 
FROM users u 
LEFT JOIN profile p ON u.id = p.user_id 
WHERE u.avatar != p.foto OR (u.avatar IS NULL AND p.foto IS NOT NULL) OR (u.avatar IS NOT NULL AND p.foto IS NULL);
```

### Manual Sync (if needed)
```sql
-- Sync profile.foto to users.avatar
UPDATE users u 
INNER JOIN profile p ON u.id = p.user_id 
SET u.avatar = p.foto 
WHERE p.foto IS NOT NULL;

-- Sync users.avatar to profile.foto  
UPDATE profile p 
INNER JOIN users u ON p.user_id = u.id 
SET p.foto = u.avatar 
WHERE u.avatar IS NOT NULL;
```
