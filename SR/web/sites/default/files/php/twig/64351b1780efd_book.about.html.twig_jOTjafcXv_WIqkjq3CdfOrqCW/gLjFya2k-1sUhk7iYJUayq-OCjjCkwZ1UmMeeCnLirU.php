<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @help_topics/book.about.html.twig */
class __TwigTemplate_668424f2b75ea302ff2e8380e208be8a extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        $context["user_overview_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getTopicLink("user.overview"));
        // line 6
        echo "<h2>";
        echo t("What is a book?", array());
        echo "</h2>
<p>";
        // line 7
        echo t("A book is a structured group of content pages, arranged in a hierarchical structure called a <em>book outline</em>. A book hierarchy can be up to nine levels deep, and a book can include <em>Book page</em> content items or other content items. Every book has a default book-specific navigation block, which contains links that lead to the previous and next pages in the book and to the level above the current page in the book's structure.", array());
        echo "</p>
<h2>";
        // line 8
        echo t("What are the permissions for books?", array());
        echo "</h2>
<p>";
        // line 9
        echo t("The following permissions are needed to create and manage books; see @user_overview_topic and its related topics for more about permissions.", array("@user_overview_topic" => ($context["user_overview_topic"] ?? null), ));
        echo "</p>
<dl>
  <dt>";
        // line 11
        echo t("Create new books", array());
        echo "</dt>
  <dd>";
        // line 12
        echo t("Allows users to add new books to the site.", array());
        echo "</dd>
  <dt>";
        // line 13
        echo t("Add content and child pages to books and manage their hierarchies", array());
        echo "</dt>
  <dd>";
        // line 14
        echo t("Allows users to add configured types of content to existing books.", array());
        echo "</dd>
  <dt>";
        // line 15
        echo t("Administer book outlines", array());
        echo "</dt>
  <dd>";
        // line 16
        echo t("Allows users to add <em>any</em> type of content to a book, use the book overview administration page, and rearrange the pages of a book from the book outline page.", array());
        echo "</dd>
  <dt>";
        // line 17
        echo t("Administer site configuration (in the System module section)", array());
        echo "</dt>
  <dd>";
        // line 18
        echo t("Allows users to do many site configuration tasks, including configuring books. This permission has security implications.", array());
        echo "</dd>
  <dt>";
        // line 19
        echo t("View printer-friendly books", array());
        echo "</dt>
  <dd>";
        // line 20
        echo t("Allows users to click the <em>printer-friendly version</em> link to generate a printer-friendly display of the page, which includes pages below it in the book outline.", array());
        echo "</dd>
  <dt>";
        // line 21
        echo t("<em>Book page</em> content permissions (in the Node module section)", array());
        echo "</dt>
  <dd>";
        // line 22
        echo t("Like other content types, the <em>Book page</em> content type has separate permissions for creating, editing, and deleting a user's own and any content items of this type.", array());
        echo "</dd>
</dl>
<h2>";
        // line 24
        echo t("Managing books", array());
        echo "</h2>
<p>";
        // line 25
        echo t("Book management is handled by the core Book module. The topics listed below will help you create, edit, and configure books.", array());
        echo "</p>";
    }

    public function getTemplateName()
    {
        return "@help_topics/book.about.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 25,  108 => 24,  103 => 22,  99 => 21,  95 => 20,  91 => 19,  87 => 18,  83 => 17,  79 => 16,  75 => 15,  71 => 14,  67 => 13,  63 => 12,  59 => 11,  54 => 9,  50 => 8,  46 => 7,  41 => 6,  39 => 5,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/book.about.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\book.about.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 5, "trans" => 6);
        static $filters = array("escape" => 9);
        static $functions = array("render_var" => 5, "help_topic_link" => 5);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'help_topic_link']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
