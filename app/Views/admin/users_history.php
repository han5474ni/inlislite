&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;&lt;?= $title ?&gt;&lt;/title&gt;
    &lt;link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"&gt;
    &lt;link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet"&gt;
    &lt;link href="&lt;?= base_url('assets/css/admin_dashboard.css') ?&gt;" rel="stylesheet"&gt;
    &lt;style&gt;
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-right: 12px;
        }
        .activity-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        .activity-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .filter-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .pagination-info {
            color: #6c757d;
            font-size: 14px;
        }
        .badge-activity {
            font-size: 12px;
            padding: 4px 8px;
        }
        .browser-info {
            font-size: 12px;
            color: #6c757d;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class="container-fluid"&gt;
        &lt;div class="row"&gt;
            &lt;!-- Sidebar --&gt;
            &lt;div class="col-md-2 sidebar"&gt;
                &lt;?= view('admin/components/sidebar') ?&gt;
            &lt;/div&gt;
            
            &lt;!-- Main Content --&gt;
            &lt;div class="col-md-10 main-content"&gt;
                &lt;div class="content-header"&gt;
                    &lt;div class="d-flex justify-content-between align-items-center"&gt;
                        &lt;div&gt;
                            &lt;h1 class="h3 mb-0"&gt;Activity History&lt;/h1&gt;
                            &lt;nav aria-label="breadcrumb"&gt;
                                &lt;ol class="breadcrumb"&gt;
                                    &lt;li class="breadcrumb-item"&gt;&lt;a href="&lt;?= base_url('admin/dashboard') ?&gt;"&gt;Dashboard&lt;/a&gt;&lt;/li&gt;
                                    &lt;li class="breadcrumb-item active"&gt;Activity History&lt;/li&gt;
                                &lt;/ol&gt;
                            &lt;/nav&gt;
                        &lt;/div&gt;
                        &lt;div&gt;
                            &lt;a href="&lt;?= base_url('admin/users-edit') ?&gt;" class="btn btn-outline-primary"&gt;
                                &lt;i class="bi bi-arrow-left"&gt;&lt;/i&gt; Back to Users
                            &lt;/a&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;

                &lt;!-- Filters --&gt;
                &lt;div class="filter-card"&gt;
                    &lt;form method="GET" action="&lt;?= base_url('admin/users/history') ?&gt;"&gt;
                        &lt;div class="row"&gt;
                            &lt;div class="col-md-3"&gt;
                                &lt;label for="search" class="form-label"&gt;Search&lt;/label&gt;
                                &lt;input type="text" class="form-control" id="search" name="search" 
                                       value="&lt;?= esc($filters['search']) ?&gt;" 
                                       placeholder="Search by user, email, or activity..."&gt;
                            &lt;/div&gt;
                            &lt;div class="col-md-2"&gt;
                                &lt;label for="date_from" class="form-label"&gt;Date From&lt;/label&gt;
                                &lt;input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="&lt;?= esc($filters['date_from']) ?&gt;"&gt;
                            &lt;/div&gt;
                            &lt;div class="col-md-2"&gt;
                                &lt;label for="date_to" class="form-label"&gt;Date To&lt;/label&gt;
                                &lt;input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="&lt;?= esc($filters['date_to']) ?&gt;"&gt;
                            &lt;/div&gt;
                            &lt;div class="col-md-2"&gt;
                                &lt;label for="activity_type" class="form-label"&gt;Activity Type&lt;/label&gt;
                                &lt;select class="form-select" id="activity_type" name="activity_type"&gt;
                                    &lt;option value=""&gt;All Activities&lt;/option&gt;
                                    &lt;?php foreach ($activityTypes as $type): ?&gt;
                                        &lt;option value="&lt;?= esc($type) ?&gt;" 
                                                &lt;?= $filters['activity_type'] === $type ? 'selected' : '' ?&gt;&gt;
                                            &lt;?= ucfirst(str_replace('_', ' ', $type)) ?&gt;
                                        &lt;/option&gt;
                                    &lt;?php endforeach; ?&gt;
                                &lt;/select&gt;
                            &lt;/div&gt;
                            &lt;div class="col-md-2"&gt;
                                &lt;label for="user_id" class="form-label"&gt;User&lt;/label&gt;
                                &lt;select class="form-select" id="user_id" name="user_id"&gt;
                                    &lt;option value=""&gt;All Users&lt;/option&gt;
                                    &lt;?php foreach ($users as $user): ?&gt;
                                        &lt;option value="&lt;?= esc($user['id']) ?&gt;" 
                                                &lt;?= $filters['user_id'] == $user['id'] ? 'selected' : '' ?&gt;&gt;
                                            &lt;?= esc($user['nama_lengkap']) ?&gt;
                                        &lt;/option&gt;
                                    &lt;?php endforeach; ?&gt;
                                &lt;/select&gt;
                            &lt;/div&gt;
                            &lt;div class="col-md-1"&gt;
                                &lt;label class="form-label"&gt;&nbsp;&lt;/label&gt;
                                &lt;div class="d-flex gap-2"&gt;
                                    &lt;button type="submit" class="btn btn-primary"&gt;
                                        &lt;i class="bi bi-search"&gt;&lt;/i&gt;
                                    &lt;/button&gt;
                                    &lt;a href="&lt;?= base_url('admin/users/history') ?&gt;" class="btn btn-outline-secondary"&gt;
                                        &lt;i class="bi bi-arrow-clockwise"&gt;&lt;/i&gt;
                                    &lt;/a&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                    &lt;/form&gt;
                &lt;/div&gt;

                &lt;!-- Results Info --&gt;
                &lt;div class="d-flex justify-content-between align-items-center mb-3"&gt;
                    &lt;div class="pagination-info"&gt;
                        Showing &lt;?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?&gt; to 
                        &lt;?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']) ?&gt; 
                        of &lt;?= $pagination['total_records'] ?&gt; results
                    &lt;/div&gt;
                    &lt;div&gt;
                        &lt;span class="badge bg-info"&gt;&lt;?= count($logs) ?&gt; activities on this page&lt;/span&gt;
                    &lt;/div&gt;
                &lt;/div&gt;

                &lt;!-- Activity Logs --&gt;
                &lt;div class="activity-logs"&gt;
                    &lt;?php if (empty($logs)): ?&gt;
                        &lt;div class="text-center py-5"&gt;
                            &lt;i class="bi bi-clock-history text-muted" style="font-size: 48px;"&gt;&lt;/i&gt;
                            &lt;h4 class="text-muted mt-3"&gt;No activity logs found&lt;/h4&gt;
                            &lt;p class="text-muted"&gt;Try adjusting your filters or check back later.&lt;/p&gt;
                        &lt;/div&gt;
                    &lt;?php else: ?&gt;
                        &lt;?php foreach ($logs as $log): ?&gt;
                            &lt;div class="activity-card"&gt;
                                &lt;div class="card-body"&gt;
                                    &lt;div class="d-flex align-items-start"&gt;
                                        &lt;div class="activity-icon bg-&lt;?= $log['activity_color'] ?&gt; text-white"&gt;
                                            &lt;i class="bi &lt;?= $log['activity_icon'] ?&gt;"&gt;&lt;/i&gt;
                                        &lt;/div&gt;
                                        &lt;div class="flex-grow-1"&gt;
                                            &lt;div class="d-flex justify-content-between align-items-start"&gt;
                                                &lt;div&gt;
                                                    &lt;h6 class="mb-1"&gt;
                                                        &lt;?= esc($log['nama_lengkap'] ?? 'Unknown User') ?&gt;
                                                        &lt;span class="badge badge-activity bg-&lt;?= $log['activity_color'] ?&gt;"&gt;
                                                            &lt;?= ucfirst(str_replace('_', ' ', $log['action'])) ?&gt;
                                                        &lt;/span&gt;
                                                    &lt;/h6&gt;
                                                    &lt;p class="mb-1 text-muted"&gt;&lt;?= esc($log['description']) ?&gt;&lt;/p&gt;
                                                    &lt;small class="text-muted"&gt;
                                                        &lt;i class="bi bi-envelope me-1"&gt;&lt;/i&gt;&lt;?= esc($log['email'] ?? 'No email') ?&gt;
                                                        &lt;i class="bi bi-geo-alt ms-3 me-1"&gt;&lt;/i&gt;&lt;?= esc($log['ip_address']) ?&gt;
                                                        &lt;span class="browser-info ms-3"&gt;
                                                            &lt;i class="bi bi-browser-chrome me-1"&gt;&lt;/i&gt;&lt;?= esc($log['browser_info']) ?&gt;
                                                        &lt;/span&gt;
                                                    &lt;/small&gt;
                                                &lt;/div&gt;
                                                &lt;div class="text-end"&gt;
                                                    &lt;small class="text-muted"&gt;
                                                        &lt;i class="bi bi-clock me-1"&gt;&lt;/i&gt;&lt;?= esc($log['created_at_formatted']) ?&gt;
                                                    &lt;/small&gt;
                                                &lt;/div&gt;
                                            &lt;/div&gt;
                                        &lt;/div&gt;
                                    &lt;/div&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;?php endforeach; ?&gt;
                    &lt;/div&gt;

                    &lt;!-- Pagination --&gt;
                    &lt;?php if ($pagination['total_pages'] &gt; 1): ?&gt;
                        &lt;nav aria-label="Activity logs pagination"&gt;
                            &lt;ul class="pagination justify-content-center"&gt;
                                &lt;!-- Previous Page --&gt;
                                &lt;li class="page-item &lt;?= $pagination['current_page'] &lt;= 1 ? 'disabled' : '' ?&gt;"&gt;
                                    &lt;a class="page-link" href="&lt;?= $pagination['current_page'] &gt; 1 ? 
                                        base_url('admin/users/history') . '?' . http_build_query(array_merge($filters, ['page' =&gt; $pagination['current_page'] - 1])) : '#' ?&gt;"&gt;
                                        Previous
                                    &lt;/a&gt;
                                &lt;/li&gt;

                                &lt;!-- Page Numbers --&gt;
                                &lt;?php 
                                $start = max(1, $pagination['current_page'] - 2);
                                $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
                                ?&gt;
                                
                                &lt;?php if ($start &gt; 1): ?&gt;
                                    &lt;li class="page-item"&gt;
                                        &lt;a class="page-link" href="&lt;?= base_url('admin/users/history') . '?' . http_build_query(array_merge($filters, ['page' =&gt; 1])) ?&gt;"&gt;1&lt;/a&gt;
                                    &lt;/li&gt;
                                    &lt;?php if ($start &gt; 2): ?&gt;
                                        &lt;li class="page-item disabled"&gt;&lt;span class="page-link"&gt;...&lt;/span&gt;&lt;/li&gt;
                                    &lt;?php endif; ?&gt;
                                &lt;?php endif; ?&gt;

                                &lt;?php for ($i = $start; $i &lt;= $end; $i++): ?&gt;
                                    &lt;li class="page-item &lt;?= $i == $pagination['current_page'] ? 'active' : '' ?&gt;"&gt;
                                        &lt;a class="page-link" href="&lt;?= base_url('admin/users/history') . '?' . http_build_query(array_merge($filters, ['page' =&gt; $i])) ?&gt;"&gt;
                                            &lt;?= $i ?&gt;
                                        &lt;/a&gt;
                                    &lt;/li&gt;
                                &lt;?php endfor; ?&gt;

                                &lt;?php if ($end &lt; $pagination['total_pages']): ?&gt;
                                    &lt;?php if ($end &lt; $pagination['total_pages'] - 1): ?&gt;
                                        &lt;li class="page-item disabled"&gt;&lt;span class="page-link"&gt;...&lt;/span&gt;&lt;/li&gt;
                                    &lt;?php endif; ?&gt;
                                    &lt;li class="page-item"&gt;
                                        &lt;a class="page-link" href="&lt;?= base_url('admin/users/history') . '?' . http_build_query(array_merge($filters, ['page' =&gt; $pagination['total_pages']])) ?&gt;"&gt;
                                            &lt;?= $pagination['total_pages'] ?&gt;
                                        &lt;/a&gt;
                                    &lt;/li&gt;
                                &lt;?php endif; ?&gt;

                                &lt;!-- Next Page --&gt;
                                &lt;li class="page-item &lt;?= $pagination['current_page'] &gt;= $pagination['total_pages'] ? 'disabled' : '' ?&gt;"&gt;
                                    &lt;a class="page-link" href="&lt;?= $pagination['current_page'] &lt; $pagination['total_pages'] ? 
                                        base_url('admin/users/history') . '?' . http_build_query(array_merge($filters, ['page' =&gt; $pagination['current_page'] + 1])) : '#' ?&gt;"&gt;
                                        Next
                                    &lt;/a&gt;
                                &lt;/li&gt;
                            &lt;/ul&gt;
                        &lt;/nav&gt;
                    &lt;?php endif; ?&gt;
                &lt;?php endif; ?&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;

    &lt;script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"&gt;&lt;/script&gt;
    &lt;script&gt;
        // Auto-submit form when filters change
        document.getElementById('activity_type').addEventListener('change', function() {
            this.form.submit();
        });
        
        document.getElementById('user_id').addEventListener('change', function() {
            this.form.submit();
        });
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
