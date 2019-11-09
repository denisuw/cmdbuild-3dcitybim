<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<%@page import="org.cmdbuild.auth.PasswordManagementService"%>
<%@ page import="com.google.common.base.Joiner" %>
<%@ page import="java.util.Collection" %>
<%@ page import="org.apache.commons.lang3.StringEscapeUtils" %>
<%@ page import="org.cmdbuild.auth.acl.CMGroup" %>
<%@ page import="org.cmdbuild.auth.user.OperationUser" %>
<%@ page import="org.cmdbuild.auth.UserStore" %>
<%@ page import="org.cmdbuild.config.GisProperties" %>
<%@ page import="org.cmdbuild.logic.auth.SessionLogic" %>
<%@ page import="org.cmdbuild.logic.auth.StandardSessionLogic" %>
<%@ page import="org.cmdbuild.services.SessionVars" %>
<%@ page import="org.cmdbuild.spring.SpringIntegrationUtils" %>
<%@ page import="org.cmdbuild.webapp.Management" %>

<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>

<%@ taglib uri="/WEB-INF/tags/translations/implicit.tld" prefix="tr" %>

<%
	final SessionLogic sessionLogic = SpringIntegrationUtils.applicationContext().getBean(StandardSessionLogic.class);
	final SessionVars sessionVars = SpringIntegrationUtils.applicationContext().getBean(SessionVars.class);
	final String lang = sessionVars.getLanguage();
	final UserStore userStore = SpringIntegrationUtils.applicationContext().getBean(UserStore.class);
	final OperationUser operationUser = userStore.getUser();
	final CMGroup group = operationUser.getPreferredGroup();
	final String defaultGroupName = operationUser.getAuthenticatedUser().getDefaultGroupName();
	final Collection<String> groupDescriptionList = operationUser.getAuthenticatedUser().getGroupDescriptions();
	final String groupDecriptions = Joiner.on(", ").join(groupDescriptionList);
	final String extVersion = "4.2.0";
	final Management helper = new Management();
	
	if (PasswordManagementService.isPasswordManagementEnabled()  && operationUser.isPasswordExpired()) {
		response.sendRedirect("change-password.jsp");
	}
%>


<%
		/*
		
		 The belowe code purpose is to detect/set/remove "dev mode"
		 In "dev mode" we will load not concatenated/minified script, otherwise
		 will be loaded concatenated and minified scripts
		 
		 
		 INSTRUCTION:
			 * In order to enable "dev mode", make a request with GET param devmode=true
			 * In order to disable "dev mode". make a request with GET param devmode=false
			 * Check the proper mode activation checking the presence of "cmdbuild-dev" cookie
			 	 
			 
		*/
		
		
		
		final String devmodeCookieName = "cmdbuild-dev";
		final String devmodeParameterName = "devmode";
		final String modeParam = request.getParameter(devmodeParameterName) != null  ? request.getParameter(devmodeParameterName) : "";
		final boolean isSecure = request.isSecure();
		
		boolean isDevMode = false;
		
		
		if(modeParam.equals("false")) {
			isDevMode = false;
		} else if(modeParam.equals("true")) {
			isDevMode = true;
		} else {
			Cookie[] _cookies = request.getCookies();
			
			int idx = 0;
			while(idx < _cookies.length) {
				if(_cookies[idx].getName().equals(devmodeCookieName)) {
					isDevMode = true;
					break;
				}
				idx++;
			}
		}
		
		
		if(isDevMode == true) {
			Cookie devmodeCookie = new Cookie (devmodeCookieName, "true");
			devmodeCookie.setPath("/");
			devmodeCookie.setMaxAge(60*60*24);
			devmodeCookie.setSecure(isSecure);
			response.addCookie(devmodeCookie);
		} else {
			Cookie devmodeCookie = new Cookie (devmodeCookieName, null);
			devmodeCookie.setPath("/");
			devmodeCookie.setMaxAge(0);
			devmodeCookie.setSecure(isSecure);
			response.addCookie(devmodeCookie);
		}
			
		
		
%>

<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="stylesheets/cmdbuild.css" />
		<link rel="stylesheet" type="text/css" href="javascripts/ext-<%= extVersion %>/resources/css/ext-all.css" />
		<link rel="stylesheet" type="text/css" href="javascripts/ext-<%= extVersion %>-ux/css/MultiSelect.css" />
		<link rel="stylesheet" type="text/css" href="javascripts/ext-<%= extVersion %>-ux/css/portal.css" />
		<link rel="stylesheet" type="text/css" href="javascripts/extensible-1.5.1/resources/css/extensible-all.css" />
		<link rel="icon" type="image/x-icon" href="images/favicon.ico" />
		
		<% if (isDevMode) { %>
			<%@ include file="libsJsFiles.jsp" %>
		<% } else { %>
			<!-- TinyMCE -->
			<script type="text/javascript" src="javascripts/ext-<%= extVersion %>-ux/form/field/tinymce/tiny_mce.js"></script>
			
			<script type="text/javascript" src="javascripts/cmdbuild/collection/libs.min.js"></script>
		<% } %>


		<!-- 1. Main script -->
		<% if (isDevMode) { %>
			<script type="text/javascript" src="javascripts/cmdbuild/core/constants/Proxy.js"></script>
			<script type="text/javascript" src="javascripts/cmdbuild/core/LoaderConfig.js"></script>
			<script type="text/javascript" src="javascripts/cmdbuild/core/Utils.js"></script>
			<script type="text/javascript" src="javascripts/log/log4javascript.js"></script>
			<script type="text/javascript" src="javascripts/cmdbuild/core/interfaces/Ajax.js"></script>
			<script type="text/javascript" src="javascripts/cmdbuild/core/Message.js"></script>
			<script type="text/javascript" src="javascripts/cmdbuild/core/CookiesManager.js"></script>
		<% } else { %>
			<script type="text/javascript" src="javascripts/cmdbuild/collection/main.min.js"></script>	
		<% } %>
		
		
		<!-- 2. Localizations --> 
		<!-- Dynamic script loading -->
		<%@ include file="localizationsJsFiles.jsp" %>
		
		
		<!-- Runtime scripts -->
		<!-- For NO dev mode this scripts are loaded in rutime by extJS engine -->
		<% if (!isDevMode) { %>
			<script type="text/javascript" src="javascripts/cmdbuild/collection/runtime.min.js"></script>
		<% } %>
		
		
		<!-- 3. Runtime configuration -->
		<script type="text/javascript">
			CMDBuild.core.CookiesManager.authorizationSet('<%= sessionLogic.getCurrent() %>'); // Authorization cookie setup

			Ext.ns('CMDBuild.configuration.runtime');
			CMDBuild.configuration.runtime = Ext.create('CMDBuild.model.core.configuration.runtime.Runtime');
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.ALLOW_PASSWORD_CHANGE, <%= operationUser.getAuthenticatedUser().canChangePassword() %>);
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.DEFAULT_GROUP_DESCRIPTION, '<%= StringEscapeUtils.escapeEcmaScript(group.getDescription()) %>');
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.DEFAULT_GROUP_ID, <%= group.getId() %>);
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.DEFAULT_GROUP_NAME, '<%= StringEscapeUtils.escapeEcmaScript(group.getName()) %>');
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.IS_ADMINISTRATOR, <%= operationUser.hasAdministratorPrivileges() %>);
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.LANGUAGE, '<%= StringEscapeUtils.escapeEcmaScript(lang) %>');
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.STARTING_CLASS_ID, <%= group.getStartingClassId() %>);
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.USER_ID, <%= operationUser.getAuthenticatedUser().getId() %>);
			CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.USERNAME, '<%= StringEscapeUtils.escapeEcmaScript(operationUser.getAuthenticatedUser().getUsername()) %>');
		</script>
		
		
		<% if (isDevMode) { %>
			<%@ include file="coreJsFiles.jsp" %>
			<%@ include file="managementJsFiles.jsp" %>
			<%@ include file="bimJsFiles.jsp" %>
		<% } else { %>
			<script type="text/javascript" src="javascripts/cmdbuild/collection/core.min.js"></script>
			<script type="text/javascript" src="javascripts/cmdbuild/collection/management.min.js"></script><script> 
		    	Global = {};
		    </script>
			<script type="text/javascript" src="javascripts/cmdbuild/collection/bim.min.js"></script>
			
		<% } %>
		
		
		
<!--
		<script type="text/javascript" src="javascripts/cmdbuild/cmdbuild-core.js"></script>
		<script type="text/javascript" src="javascripts/cmdbuild/cmdbuild-management.js"></script>
-->

		<!-- GIS -->
		<%
			if (helper.isGisEnabled()) {
				if (helper.isGoogleServiceOn()) {
		%>
					<script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
			<% } %>

			<% if (helper.isYahooServiceOn()) { %>
						<script src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=<%=helper.getYahooKey()%>"></script>
			<% } %>
			<%@ include file="gisJsFiles.jsp" %>
		<% } %>
		
		<% if (!isDevMode) { %>
			<script type="text/javascript" src="javascripts/cmdbuild/collection/app.min.js"></script>
		<% } %>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.4/build/pannellum.css"/>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.4/build/pannellum.js"></script>
		<style>
		#panorama {
			width: 1000px;
			height: 500px;
		}
		</style>


		<!-- 4. Modules -->
		<script type="text/javascript" src="javascripts/cmdbuild/Management.js"></script>
		

		<title>CMDBuild</title>
	</head>
	<body>	
		<div id="header" class="display-none">
			<a href="http://www.cmdbuild.org" target="_blank"><img src="images/logo.png" alt="CMDBuild logo" /></a>
			<div id="instance-name"></div>
			<div class="description">Open Source Configuration and Management Database</div>

			<!-- Required to display the map-->
			<div id="map"> </div>

			<div id="msg-ct" class="msg-blue">
				<div id="msg">
					<div id="msg-inner">
						<p><tr:translation key="common.user"/>: <strong><%= operationUser.getAuthenticatedUser().getDescription() %></strong> | <a href="logout.jsp"><tr:translation key="common.logout"/></a></p>
						<% if (defaultGroupName == null || "".equals(defaultGroupName) ) { %>
							<p id="msg-inner-hidden"><tr:translation key="common.group"/>: <strong><%= group.getDescription() %></strong>
						<%	} else { %>
							<p id="msg-inner-hidden"><tr:translation key="common.group"/>: <strong><tr:translation key="multiGroup"/></strong>

							<script type="text/javascript">
								CMDBuild.configuration.runtime.set(CMDBuild.core.constants.Proxy.GROUP_DESCRIPTIONS, '<%= StringEscapeUtils.escapeEcmaScript(groupDecriptions) %>');
							</script>
						<% } %>

						<% if (operationUser.hasAdministratorPrivileges()) { %>
							| <a href="administration.jsp"><tr:translation key="administration.description"/></a>
						<% } %>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div id="footer" class="display-none">
			<div class="left"><a href="http://www.cmdbuild.org" target="_blank">www.cmdbuild.org</a></div>
			<div id="cmdbuild-credits-link" class="center"><tr:translation key="common.credits"/></div>
			<div class="right"><a href="http://www.tecnoteca.com" target="_blank">Copyright &copy; Tecnoteca srl</a></div>
		</div>
	</body>
</html>