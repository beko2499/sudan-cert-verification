<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * عرض نموذج إضافة مدير جديد
     */
    public function create()
    {
        $universities = University::where('is_active', true)
            ->orderBy('name_ar')
            ->get();
            
        return view('admin.users.create', compact('universities'));
    }
    
    /**
     * حفظ مدير جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,university_admin',
            'university_id' => 'required_if:role,university_admin|nullable|exists:universities,id',
            'is_active' => 'boolean'
        ]);
        
        // تشفير كلمة المرور
        $validated['password'] = Hash::make($validated['password']);
        
        // تحويل is_active
        $validated['is_active'] = $request->has('is_active');
        
        // إذا كان admin، تأكد من أن university_id = null
        if ($validated['role'] === 'admin') {
            $validated['university_id'] = null;
        }
        
        // إنشاء المستخدم
        $user = User::create($validated);
        
        // إضافة الدور باستخدام Spatie
        $user->assignRole($validated['role']);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'تم إنشاء حساب المدير بنجاح ✅');
    }
    
    /**
     * عرض قائمة المستخدمين
     */
    public function index()
    {
        $users = User::with('university')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * عرض نموذج تعديل مستخدم
     */
    public function edit(User $user)
    {
        $universities = University::where('is_active', true)
            ->orderBy('name_ar')
            ->get();
            
        return view('admin.users.edit', compact('user', 'universities'));
    }
    
    /**
     * تحديث بيانات مستخدم
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,university_admin',
            'university_id' => 'required_if:role,university_admin|nullable|exists:universities,id',
            'is_active' => 'boolean'
        ]);
        
        // تحديث كلمة المرور إذا تم إدخالها
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        // تحويل is_active
        $validated['is_active'] = $request->has('is_active');
        
        // إذا كان admin، تأكد من أن university_id = null
        if ($validated['role'] === 'admin') {
            $validated['university_id'] = null;
        }
        
        // تحديث البيانات
        $user->update($validated);
        
        // تحديث الدور
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح ✅');
    }
    
    /**
     * حذف مستخدم
     */
    public function destroy(User $user)
    {
        // منع حذف الحساب الحالي
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص ❌');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح ✅');
    }
}