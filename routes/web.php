<?php

Route::get('/', 'HomeController')->name('home');


Auth::routes();

Route::get('invites/{token}', 'InviteController')->name('invites.index');
Route::get('new-member/{token}', 'NewMemberController')->name('new-member.index');
Route::post('new-member/{token}', 'StoreMemberController')->name('new-member.store');

Route::group(['middleware' => ['auth']], function () {

    Route::get('password/reset-email', 'Auth\ResetPasswordForLoggedInController@reset');

    // Group interaction pages
    Route::get('groups/{group}', 'Group\MemberDashboardController')->name('groups.member-dashboard');
    Route::get('groups/{group}/profiles', 'Group\ProfileIndexController')->name('groups.profiles.index');
    Route::get('groups/{group}/profiles/{member}', 'Group\ProfileDisplayController')->name('groups.profiles.show');
    Route::get('groups/{group}/profiles/{member}/edit', 'Group\ProfileEditController')->name('groups.profiles.edit');
    Route::get('groups/{group}/profiles/{member}/plan', 'Group\ProfilePlanEditController')->name('groups.profiles.plan.edit');
    Route::get('groups/{group}/analytics', 'Group\AnalyticsController')->name('groups.analytics.index');
    Route::get('groups/{group}/facilitator', 'Group\FacilitatorController')->name('groups.facilitator');
    Route::get('groups/{group}/give-feedback', 'Group\GiveFeedbackController')->name('groups.give-feedback');
    Route::post('groups/{group}/advance-process', 'Group\AdvanceProcessController')->name('groups.current-process.store');
    Route::post('groups/{group}/check-in', 'Group\StoreCheckInPeriodController')->name('groups.check-in.store');
    Route::resource('groups.channels', 'Group\ChannelController');

    // Member on-boarding
    Route::get('onboarding', 'Onboarding\OnboardingController')->name('onboarding');
    Route::get('onboarding/verify', 'Onboarding\VerifyController')->name('onboarding.verify');
    Route::post('onboarding/verify', 'Onboarding\StoreVerifyController');
    Route::get('onboarding/welcome', 'Onboarding\WelcomeController')->name('onboarding.welcome');
    Route::post('onboarding/welcome', 'Onboarding\StoreWelcomeController');
    Route::get('onboarding/about', 'Onboarding\AboutController')->name('onboarding.about');
    Route::post('onboarding/about', 'Onboarding\StoreAboutController');
    Route::get('onboarding/agreements', 'Onboarding\AgreementController')->name('onboarding.agreements');
    Route::post('onboarding/agreements', 'Onboarding\StoreAgreementController');
    Route::get('onboarding/expectations', 'Onboarding\ExpectationController')->name('onboarding.expectations');
    Route::post('onboarding/expectations', 'Onboarding\StoreExpectationController');

    // Discussions
    Route::get('groups/{group}/discussions/{disc?}', 'Discussion\GroupDiscussionListingController')->name('groups.discussions.index')->where('disc', '[0-9]+');;
    Route::get('meetings/{group}/discussions', 'Discussion\MeetingDiscussionListingController')->name('meetings.discussions.index');
    Route::get('members/{member}/discussions', 'Discussion\PrivateDiscussionListingController')->name('members.discussions.index');
    Route::get('groups/{group}/discussions/create', 'Discussion\GroupDiscussionCreateController')->name('groups.discussions.create');
    Route::get('members/{member}/discussions/create', 'Discussion\PrivateDiscussionCreateController')->name('members.discussions.create');
    Route::get('groups/{group}/discussions/{discussion}', 'Discussion\DiscussionThreadController')->name('groups.discussions.show');
    Route::post('groups/{group}/discussions', 'Discussion\GroupDiscussionStoreController')->name('groups.discussions.store');
    Route::post('members/{member}/discussions', 'Discussion\MemberDiscussionStoreController')->name('members.discussions.store');
    Route::patch('discussions/{discussion}', 'Discussion\DiscussionUpdateController')->name('discussions.update');
    Route::delete('discussions/{discussion}', 'Discussion\DiscussionDestroyController')->name('discussions.destroy');
    Route::post('discussions/{discussion}/replies', 'Discussion\ReplyStoreController')->name('discussions.replies.store');
    Route::patch('replies/{reply}', 'Discussion\ReplyUpdateController')->name('replies.update');
    Route::delete('replies/{reply}', 'Discussion\ReplyDestroyController')->name('replies.destroy');
    Route::post('discussions/{discussion}/subscription', 'Discussion\SubscribeController')->name('discussions.subscriptions.store');
    Route::post('discussions/{discussion}/mark-as-read', 'Discussion\MarkAsReadController')->name('discussions.mark-as-read.store');
    Route::post('discussions/{group}/search', 'Discussion\SearchUserController');

    // Update member profile
    Route::patch('members/{member}/big-picture', 'Member\UpdateBigPictureController');
    Route::patch('members/{member}/personal-motivation', 'Member\UpdatePersonalMotivationController');
    Route::patch('members/{member}/personal-background', 'Member\UpdatePersonalBackgroundController');
    Route::patch('members/{member}/professional-background', 'Member\UpdateProfessionalBackgroundController');
    Route::patch('members/{member}/contact', 'Member\UpdateContactInfoController');
    Route::resource('members.goals', 'Member\GoalController', ['only' => ['update']]);
    Route::patch('members/{member}/objectives/{objective}/completed', 'Member\ObjectiveCompletedStatusController');
    Route::resource('members.commitments', 'Member\CommitmentController', ['only' => ['store', 'update', 'destroy']]);
    Route::patch('members/{member}/commitments/{commitment}/completed', 'Member\CommitmentCompletedStatusController');
    Route::resource('members.objectives', 'Member\ObjectiveController', ['only' => ['store', 'update', 'destroy']]);

    // User resources
    Route::resource('active-group', 'ActiveGroupController', ['only' => ['index', 'update']]);

    // Meetings
    Route::resource('groups.meetings', 'Group\MeetingController');
    Route::resource('meetings.agendas', 'Group\Meeting\AgendaController');
    Route::resource('meetings.participants', 'Group\Meeting\ParticipantController', ['only' => 'update']);
    Route::patch('meetings/{meeting}/advance', 'Group\Meeting\MeetingStatusController@update')->name('meetings.status.update');
    Route::delete('meetings/{meeting}/rollback', 'Group\Meeting\MeetingStatusController@destroy')->name('meetings.status.destroy');

    // Participating in meetings
    Route::get('participants/{participant}/accept', 'Group\MeetingResponseController@accept')->name('participants.accept');
    Route::get('participants/{participant}/reject', 'Group\MeetingResponseController@reject')->name('participants.reject');

    // Discussions
    Route::resource('channels.messages', 'Discussion\MessageController', ['except' => ['create', 'edit']]);

    // Live Testing
    Route::resource('tests', 'TestController');

    // On-boarding
    Route::get('members/{member}/onboarding/1', 'Member\OnboardingController@step_1');
    Route::get('members/{member}/onboarding/2', 'Member\OnboardingController@step_2');
    Route::get('members/{member}/onboarding/3', 'Member\OnboardingController@step_what_to_expect');
    Route::get('members/{member}/onboarding/4', 'Member\OnboardingController@step_shared_expectations');
    Route::get('members/{member}/onboarding/5', 'Member\OnboardingController@step_survey');
    Route::get('members/{member}/onboarding/6', 'Member\OnboardingController@finished');

    // Group insights
    Route::get('insights/analytics', 'Insights\AnalyticsController')->name('insights.analytics');
    Route::get('insights/feedback', 'Insights\FeedbackController')->name('insights.feedback');
    Route::get('insights/history', 'Insights\HistoryController')->name('insights.history');
    Route::get('insights/praise', 'Insights\PraiseController')->name('insights.praise');
    Route::get('insights/exceptions', 'Insights\ExceptionsController')->name('insights.exceptions');

    // Manage people
    Route::get('manage-members', 'ManageMembers\ListMembersController')->name('manage-members.index');
    Route::get('manage-members/invites', 'ManageMembers\ListInvitedController')->name('manage-members.invites.index');
    Route::post('manage-members/invites', 'ManageMembers\StoreInvitedController')->name('manage-members.invites.store');
    Route::delete('manage-members/invites/{invite}', 'ManageMembers\DestroyInvitedController')->name('manage-members.invites.destroy');
    Route::patch('manage-members/{member}', 'ManageMembers\UpdateMemberController')->name('manage-members.update');
    Route::delete('manage-members/{member}', 'ManageMembers\DeleteMemberController')->name('manage-members.destroy');

    // Edit group settings
    Route::get('groups/{group}/profile', 'ManageGroup\ShowController')->name('manage-group.show');
    Route::get('groups/{group}/edit', 'ManageGroup\EditController')->name('manage-group.edit');
    Route::patch('groups/{group}', 'ManageGroup\UpdateController')->name('manage-group.update');

    // Edit group configuration
    Route::get('group-configuration/about', 'GroupConfig\AboutController')->name('groups.config.about');
    Route::get('group-configuration/agreements', 'GroupConfig\AgreementController')->name('groups.config.agreements');
    Route::get('group-configuration/feedback', 'GroupConfig\FeedbackController')->name('groups.config.feedback');
    Route::get('group-configuration/check-ins', 'GroupConfig\CheckInController')->name('groups.config.check-ins');
    Route::get('group-configuration/planning', 'GroupConfig\PlanningController')->name('groups.config.planning');
    Route::get('group-configuration/profiles', 'GroupConfig\ProfileController')->name('groups.config.profiles');
    Route::get('group-configuration/engagement', 'GroupConfig\EngagementController')->name('groups.config.engagement');

    // Update expectations
    Route::post('group-configuration/about', 'GroupConfig\StoreAboutController')->name('groups.config.about.store');
    Route::patch('group-configuration/about/{expectation}', 'GroupConfig\UpdateAboutController')->name('groups.config.about.update');
    Route::delete('group-configuration/about/{expectation}', 'GroupConfig\DeleteAboutController')->name('groups.config.about.destroy');

    // Update agreements
    Route::post('group-configuration/agreements', 'GroupConfig\StoreAgreementController')->name('groups.config.agreements.store');
    Route::patch('group-configuration/agreements/{agreement}', 'GroupConfig\UpdateAgreementController')->name('groups.config.agreements.update');
    Route::delete('group-configuration/agreements/{agreement}', 'GroupConfig\DeleteAgreementController')->name('groups.config.agreements.destroy');

    // Update feedback
    Route::post('group-configuration/feedback', 'GroupConfig\StoreFeedbackController')->name('groups.config.feedback.store');
    Route::patch('group-configuration/feedback/{question}', 'GroupConfig\UpdateFeedbackController')->name('groups.config.feedback.update');
    Route::delete('group-configuration/feedback/{question}', 'GroupConfig\DeleteFeedbackController')->name('groups.config.feedback.destroy');

    // Update other group configuration settings
    Route::post('group-configuration/check-ins', 'GroupConfig\StoreCheckInController')->name('groups.config.check-ins.store');
    Route::post('group-configuration/planning', 'GroupConfig\StorePlanningController')->name('groups.config.planning.store');
    Route::post('group-configuration/profiles', 'GroupConfig\StoreProfileController')->name('groups.config.profiles.store');
    Route::post('group-configuration/engagement', 'GroupConfig\StoreEngagementController')->name('groups.config.engagement.store');

    // Edit account
    Route::get('account', 'Account\DashboardController')->name('accounts.index');
    Route::get('account/subscriptions', 'Account\SubscriptionController')->name('accounts.subscriptions');
    Route::get('account/groups', 'Account\GroupController')->name('accounts.groups');
    Route::get('account/branding', 'Account\BrandingController')->name('accounts.branding');
    Route::get('account/contact', 'Account\ContactController')->name('accounts.contact');
    Route::get('account/security', 'Account\SecurityController')->name('accounts.security');
    Route::get('account/integrations', 'Account\IntegrationController')->name('accounts.integrations');
    Route::get('account/notifications', 'Account\NotificationController')->name('accounts.notifications');

    // Update groups
    Route::post('account/groups', 'Account\StoreGroupController')->name('accounts.groups.store');
    Route::patch('account/groups/{group}', 'Account\UpdateGroupController')->name('accounts.groups.update');
    Route::delete('account/groups/{group}', 'Account\DeleteGroupController')->name('accounts.groups.destroy');

    // Update other account settings
    Route::post('account/subscriptions', 'Account\StoreSubscriptionController')->name('accounts.subscriptions.store');
    Route::post('account/branding', 'Account\StoreBrandingController')->name('accounts.branding.store');
    Route::post('account/contact', 'Account\StoreContactController')->name('accounts.contact.store');
    Route::post('account/security', 'Account\StoreSecurityController')->name('accounts.security.store');
    Route::post('account/integrations', 'Account\StoreIntegrationController')->name('accounts.integrations.store');
    Route::post('account/notifications', 'Account\StoreNotificationsController')->name('accounts.notifications.store');
    Route::post('account/notifications/update', 'Account\UpdateNotificationsController');

    // Store feedback
    Route::post('groups/{group}/give-feedback', 'Group\StoreFeedbackController')->name('groups.give-feedback.store');
});