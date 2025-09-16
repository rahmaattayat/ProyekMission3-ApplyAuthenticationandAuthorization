<?php 
function isAdmin(): bool   { return session()->get('role') === 'admin'; }
function isStudent(): bool { return session()->get('role') === 'student'; }
?>