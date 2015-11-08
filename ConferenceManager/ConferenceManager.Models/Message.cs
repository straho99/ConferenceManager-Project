namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;

    public class Message
    {
        [Key]
        public int Key { get; set; }

        [Required]
        public int SenderId { get; set; }

        public User Sender { get; set; }

        [Required]
        public int RecipientId { get; set; }

        public User Recipient { get; set; }

        [Required]
        public string Content { get; set; }
    }
}
